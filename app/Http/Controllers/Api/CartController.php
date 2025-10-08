<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // public function index(Request $request)
    // {
    //     $cartItems = Cart::where('user_id', $request->user()->id)
    //         ->with(['product.category'])
    //         ->get();

    //     $total = $cartItems->sum(function ($item) {
    //         return $item->quantity * $item->product->price;
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'data' => [
    //             'items' => $cartItems,
    //             'total' => $total,
    //             'count' => $cartItems->count()
    //         ]
    //     ]);
    // }
    public function index(Request $request)
{
    $cartItems = Cart::where('user_id', $request->user()->id)
        ->with(['product.category'])
        ->get()
        ->map(function($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'price' => $item->price ?? $item->product->price,
                'quantity' => $item->quantity,
                'image' => $item->product->image_url,
            ];
        });

    $total = $cartItems->sum(function ($item) {
        return $item['quantity'] * $item['price'];
    });

    return response()->json([
        'success' => true,
        'data' => $cartItems,
        'total' => $total,
        'count' => $cartItems->count()
    ]);
}

    // public function add(Request $request)
    // {
    //     $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //         'quantity' => 'required|integer|min:1',
    //     ]);

    //     $product = Product::find($request->product_id);
        
    //     if ($product->stock_quantity < $request->quantity) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Insufficient stock'
    //         ], 400);
    //     }

    //     $cartItem = Cart::where('user_id', $request->user()->id)
    //         ->where('product_id', $request->product_id)
    //         ->first();

    //     if ($cartItem) {
    //         $newQuantity = $cartItem->quantity + $request->quantity;
            
    //         if ($product->stock_quantity < $newQuantity) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Insufficient stock'
    //             ], 400);
    //         }
            
    //         $cartItem->update(['quantity' => $newQuantity]);
    //     } else {
    //         $cartItem = Cart::create([
    //             'user_id' => $request->user()->id,
    //             'product_id' => $request->product_id,
    //             'quantity' => $request->quantity,
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Item added to cart',
    //         'data' => $cartItem->load('product')
    //     ]);
    // }
    public function add(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $product = Product::find($request->product_id);
    
    if ($product->stock_quantity < $request->quantity) {
        return response()->json([
            'success' => false,
            'message' => 'Insufficient stock'
        ], 400);
    }

    $cartItem = Cart::where('user_id', $request->user()->id)
        ->where('product_id', $request->product_id)
        ->first();

    if ($cartItem) {
        $newQuantity = $cartItem->quantity + $request->quantity;
        
        if ($product->stock_quantity < $newQuantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock'
            ], 400);
        }
        
        $cartItem->update(['quantity' => $newQuantity]);
    } else {
        $cartItem = Cart::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $product->price, // ADD THIS LINE
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Item added to cart',
        'data' => $cartItem->load('product')
    ]);
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        if ($cartItem->product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock'
            ], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'data' => $cartItem->load('product')
        ]);
    }

    public function remove(Request $request, $id)
    {
        $cartItem = Cart::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart'
        ]);
    }

    public function clear(Request $request)
    {
        Cart::where('user_id', $request->user()->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared'
        ]);
    }

    public function count(Request $request)
    {
        $count = Cart::where('user_id', $request->user()->id)->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}
