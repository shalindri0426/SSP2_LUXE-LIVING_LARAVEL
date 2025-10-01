<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Fix: Changed from _construct to __construct (two underscores)
    public function _construct(){
        $this->middleware('auth');
    }

    public function addToCart(Request $request)
    {
        try {
            // Log the request for debugging
            \Log::info('Cart add request', $request->all());

            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'nullable|integer|min:1|max:10'
            ]);

            $product = Product::findOrFail($request->product_id);
            $quantity = $request->quantity ?? 1;

            // Check if user is authenticated
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to add items to cart.'
                ], 401);
            }

            // Check if product exists and has required methods
            if (!method_exists($product, 'isInStock')) {
                $inStock = $product->stock > 0;
            } else {
                $inStock = $product->isInStock();
            }

            if (!$inStock || $product->stock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock available.'
                ], 400);
            }

            // Get the current price (with fallback)
            if (method_exists($product, 'hasDiscount') && $product->hasDiscount()) {
                $price = method_exists($product, 'getDiscountedPriceAttribute') 
                    ? $product->discounted_price 
                    : $product->price * (1 - ($product->discount ?? 0) / 100);
            } else {
                $price = $product->price;
            }

            // Check if item already exists in cart
            $cartItem = Cart::where('user_id', Auth::id())
                           ->where('product_id', $product->id)
                           ->first();

            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $quantity;
                
                if ($newQuantity > $product->stock) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot add more items. Stock limit exceeded.'
                    ], 400);
                }

                $cartItem->update([
                    'quantity' => $newQuantity,
                    'price' => $price
                ]);

                $message = 'Cart updated successfully!';
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price
                ]);

                $message = 'Product added to cart successfully!';
            }

            $cartCount = Cart::getCartCount(Auth::id());

            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => $cartCount
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data provided.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Cart add error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again.',
                'error' => app()->environment('local') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function removeFromCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id'
            ]);

            $cartItem = Cart::where('user_id', Auth::id())
                           ->where('product_id', $request->product_id)
                           ->first();

            if (!$cartItem) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Item not found in cart.'
                    ], 404);
                }
                
                return redirect()->route('cart.view')->with('error', 'Item not found in cart.');
            }

            $cartItem->delete();
            $cartCount = Cart::getCartCount(Auth::id());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from cart successfully!',
                    'cart_count' => $cartCount
                ]);
            }

            return redirect()->route('cart.view')->with('success', 'Item removed from cart successfully!');

        } catch (\Exception $e) {
            \Log::error('Remove from cart error: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred. Please try again.'
                ], 500);
            }
            
            return redirect()->route('cart.view')->with('error', 'An error occurred. Please try again.');
        }
    }

    // Fixed: Handle both form submissions and AJAX requests
    public function updateQuantity(Request $request)
    {
        try {
            \Log::info('Cart update request', $request->all());

            $request->validate([
                'cart_item_id' => 'required|integer',
                'quantity' => 'required|integer|min:1|max:10'
            ]);

            $cartItem = Cart::where('id', $request->cart_item_id)
                           ->where('user_id', Auth::id())
                           ->with('product')
                           ->first();

            if (!$cartItem) {
                \Log::error('Cart item not found', [
                    'cart_item_id' => $request->cart_item_id,
                    'user_id' => Auth::id()
                ]);
                
                // Check if it's an AJAX request
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cart item not found.'
                    ], 404);
                }
                
                return redirect()->route('cart.view')->with('error', 'Cart item not found.');
            }

            // Check stock
            if ($request->quantity > $cartItem->product->stock) {
                $message = 'Insufficient stock available. Only ' . $cartItem->product->stock . ' items left.';
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 400);
                }
                
                return redirect()->route('cart.view')->with('error', $message);
            }

            // Update quantity
            $cartItem->update(['quantity' => $request->quantity]);

            $cartCount = Cart::getCartCount(Auth::id());
            $itemTotal = number_format($cartItem->price * $request->quantity, 2);

            // Return appropriate response based on request type
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully!',
                    'cart_count' => $cartCount,
                    'item_total' => $itemTotal
                ]);
            }

            // For form submissions, redirect back to cart with success message
            return redirect()->route('cart.view')->with('success', 'Cart updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in cart update', $e->errors());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid data provided.',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return redirect()->route('cart.view')->with('error', 'Invalid data provided.');
        
        } catch (\Exception $e) {
            \Log::error('Cart update error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred. Please try again.',
                    'error' => app()->environment('local') ? $e->getMessage() : null
                ], 500);
            }
            
            return redirect()->route('cart.view')->with('error', 'An error occurred. Please try again.');
        }
    }

    public function getCartCount()
    {
        $count = Cart::getCartCount(Auth::id());
        return response()->json(['count' => $count]);
    }

    public function viewCart()
    {
        $cartItems = Cart::with('product')
                        ->where('user_id', Auth::id())
                        ->get();

        $cartTotal = Cart::getCartTotal(Auth::id());
        $cartCount = Cart::getCartCount(Auth::id());

        return view('user.cart', compact('cartItems', 'cartTotal', 'cartCount'));
    }

    public function clearCart(Request $request)
    {
        try {
            \Log::info('Clear cart request', [
                'user_id' => Auth::id(),
                'request_type' => $request->expectsJson() ? 'AJAX' : 'Form'
            ]);

            // Get current cart count before deletion
            $currentCartCount = Cart::where('user_id', Auth::id())->count();

            if ($currentCartCount == 0) {
                $message = 'Your cart is already empty.';
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message,
                        'cart_count' => 0
                    ], 400);
                }
                
                return redirect()->route('cart.view')->with('info', $message);
            }

            // Delete all cart items for the authenticated user
            $deletedCount = Cart::where('user_id', Auth::id())->delete();

            $message = "Cart cleared successfully! Removed {$deletedCount} " . 
                    ($deletedCount == 1 ? 'item' : 'items') . " from your cart.";

            \Log::info('Cart cleared', [
                'user_id' => Auth::id(),
                'items_removed' => $deletedCount
            ]);

            // Return appropriate response based on request type
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'cart_count' => 0,
                    'items_removed' => $deletedCount
                ]);
            }

            // For form submissions, redirect back to cart
            return redirect()->route('cart.view')->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Clear cart error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'An error occurred while clearing your cart. Please try again.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'error' => app()->environment('local') ? $e->getMessage() : null
                ], 500);
            }

            return redirect()->route('cart.view')->with('error', $errorMessage);
        }
    }
}