<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function count(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json(['count' => 0]);
            }

            // Queries MongoDB
            $count = Wishlist::where('user_id', $user->id)->count();
            
            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            \Log::error('Wishlist count error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get wishlist count'], 500);
        }
    }

    // Change the parameter names to match your routes
public function check(Request $request, $product_id)
{
    try {
        $user = $request->user();
        
        if (!$user || !$product_id) {
            return response()->json(['inWishlist' => false]);
        }

        $inWishlist = Wishlist::isInWishlist($user->id, $product_id);
        
        return response()->json(['inWishlist' => $inWishlist]);
    } catch (\Exception $e) {
        \Log::error('Wishlist check error: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to check wishlist'], 500);
    }
}

public function remove(Request $request, $product_id)
{
    try {
        $user = $request->user();
        
        Wishlist::removeFromWishlist($user->id, $product_id);

        $count = Wishlist::where('user_id', $user->id)->count();

        return response()->json([
            'message' => 'Removed from wishlist',
            'inWishlist' => false,
            'count' => $count
        ]);
    } catch (\Exception $e) {
        \Log::error('Wishlist remove error: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to remove from wishlist'], 500);
    }
}

    public function add(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id'
            ]);

            $user = $request->user();
            
            // Saves to MongoDB
            Wishlist::addToWishlist($user->id, $request->product_id);

            return response()->json([
                'message' => 'Added to wishlist',
                'inWishlist' => true
            ]);
        } catch (\Exception $e) {
            \Log::error('Wishlist add error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to add to wishlist'], 500);
        }
    }

    // METHOD FOR FLUTTER API - Returns JSON
    public function apiIndex(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }
            
            // Get wishlists from MongoDB
            $wishlists = Wishlist::where('user_id', $user->id)->get();
            
            // Manually load products from MySQL for each wishlist item
            $wishlistData = $wishlists->map(function($wishlist) {
                // Fetch product from MySQL
                $product = \App\Models\Product::find($wishlist->product_id);
                
                if (!$product) {
                    return null; // Skip if product doesn't exist
                }
                
                return [
                    'id' => (string)($wishlist->_id ?? $wishlist->id),
                    'user_id' => $wishlist->user_id,
                    'product_id' => $wishlist->product_id,
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'display_price' => 'LKR ' . number_format($product->price, 2),
                        'image_url' => $product->image_url,
                        'stock_quantity' => $product->stock_quantity,
                        'in_stock' => $product->stock_quantity > 0,
                        'category_id' => $product->category_id,
                    ],
                    'created_at' => $wishlist->created_at ? $wishlist->created_at->toIso8601String() : null,
                    'updated_at' => $wishlist->updated_at ? $wishlist->updated_at->toIso8601String() : null,
                ];
            })->filter()->values(); // Remove null entries and reset keys
            
            return response()->json([
                'success' => true,
                'wishlists' => $wishlistData
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Wishlist API index error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'error' => 'Failed to load wishlist',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            
            if (!$user) {
                return redirect()->route('login');
            }
            
            // Get wishlists from MongoDB
            $wishlists = Wishlist::where('user_id', $user->id)->get();
            
            
            // Manually load products from MySQL for each wishlist item
            $wishlistData = $wishlists->map(function($wishlist) {
                // Fetch product from MySQL
                $product = \App\Models\Product::find($wishlist->product_id);
                
                if (!$product) {
                    return null; // Skip if product doesn't exist
                }
                
                return [
                    'id' => $wishlist->_id ?? $wishlist->id,
                    'product' => $product,
                    'created_at' => $wishlist->created_at,
                ];
            })->filter(); // Remove null entries
            
            return view('user.wishlist', ['wishlist' => $wishlistData]);
            
        } catch (\Exception $e) {
            \Log::error('Wishlist index error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Failed to load wishlist: ' . $e->getMessage());
        }
    }   
}