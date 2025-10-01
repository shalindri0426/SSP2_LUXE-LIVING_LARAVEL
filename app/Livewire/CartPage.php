<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartPage extends Component
{
    public $cartItems = [];
    public $cartTotal = 0;
    public $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $this->cartTotal = Cart::getCartTotal(Auth::id());
        $this->cartCount = Cart::getCartCount(Auth::id());
    }

    public function updateQuantity($cartItemId, $change)
    {
        $cartItem = Cart::where('id', $cartItemId)
            ->where('user_id', Auth::id())
            ->with('product')
            ->first();

        if (!$cartItem) {
            session()->flash('error', 'Cart item not found.');
            return;
        }

        $newQuantity = $cartItem->quantity + $change;

        if ($newQuantity < 1) {
            session()->flash('error', 'Quantity cannot be less than 1.');
            return;
        }

        if ($newQuantity > $cartItem->product->stock) {
            session()->flash('error', 'Insufficient stock available. Only ' . $cartItem->product->stock . ' items left.');
            return;
        }

        $cartItem->update(['quantity' => $newQuantity]);
        
        $this->loadCart();
        $this->dispatch('cartUpdated');
        session()->flash('success', 'Cart updated successfully!');
    }

    public function removeItem($productId)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if (!$cartItem) {
            session()->flash('error', 'Item not found in cart.');
            return;
        }

        $cartItem->delete();
        
        $this->loadCart();
        $this->dispatch('cartUpdated');
        session()->flash('success', 'Item removed from cart successfully!');
    }

    public function clearCart()
    {
        if ($this->cartCount == 0) {
            session()->flash('info', 'Your cart is already empty.');
            return;
        }

        $deletedCount = Cart::where('user_id', Auth::id())->delete();
        
        $this->loadCart();
        $this->dispatch('cartUpdated');
        session()->flash('success', "Cart cleared successfully! Removed {$deletedCount} " . 
            ($deletedCount == 1 ? 'item' : 'items') . " from your cart.");
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}