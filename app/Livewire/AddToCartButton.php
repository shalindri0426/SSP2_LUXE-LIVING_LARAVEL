<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AddToCartButton extends Component
{
    public $productId;
    public $quantity = 1;
    public $isAdding = false;

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function addToCart()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please login to add items to cart.');
            return redirect()->route('login', ['redirect' => url()->current()]);
        }

        $this->isAdding = true;

        $product = Product::findOrFail($this->productId);

        // Check stock
        $inStock = method_exists($product, 'isInStock') ? $product->isInStock() : ($product->stock > 0);
        
        if (!$inStock || $product->stock < $this->quantity) {
            session()->flash('error', 'Insufficient stock available.');
            $this->isAdding = false;
            return;
        }

        // Get price
        if (method_exists($product, 'hasDiscount') && $product->hasDiscount()) {
            $price = method_exists($product, 'getDiscountedPriceAttribute') 
                ? $product->discounted_price 
                : $product->price * (1 - ($product->discount ?? 0) / 100);
        } else {
            $price = $product->price;
        }

        // Check if item exists in cart
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $this->quantity;
            
            if ($newQuantity > $product->stock) {
                session()->flash('error', 'Cannot add more items. Stock limit exceeded.');
                $this->isAdding = false;
                return;
            }

            $cartItem->update([
                'quantity' => $newQuantity,
                'price' => $price
            ]);

            session()->flash('success', 'Cart updated successfully!');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $this->quantity,
                'price' => $price
            ]);

            session()->flash('success', 'Product added to cart successfully!');
        }

        $this->dispatch('cartUpdated');
        $this->isAdding = false;
    }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}