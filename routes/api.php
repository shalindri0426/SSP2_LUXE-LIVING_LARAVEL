<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminMainController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProfileController;
use Laravel\Fortify\Features;



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Get categories and products
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}/products', [CategoryController::class, 'products']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Protected routes - Customer
Route::middleware(['auth:sanctum', 'rolemanager:customer'])->group(function () {
    // User profile
    Route::get('/user/profile', [AuthController::class, 'profile']);
    Route::match(['post','put'],'/profile/update', [ProfileController::class, 'apiUpdate']);
    
    // Cart management
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/add', [CartController::class, 'add']);
        Route::put('/update/{id}', [CartController::class, 'update']);
        Route::delete('/remove/{id}', [CartController::class, 'remove']);
        Route::delete('/clear', [CartController::class, 'clear']);
        Route::get('/count', [CartController::class, 'count']);
    });

    // Wishlist management
    Route::prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'apiIndex']);
        Route::get('/count', [WishlistController::class, 'count']);
        Route::get('/check/{product_id}', [WishlistController::class, 'check']);
        Route::post('/add', [WishlistController::class, 'add']);
        Route::delete('/remove/{product_id}', [WishlistController::class, 'remove']);
    });

    // Order management
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'apiStore']);
        Route::get('/{id}', [OrderController::class, 'show']);
        Route::get('/{id}/payment', [OrderController::class, 'payment']);
    });

    // Payment
    Route::post('/payment/{order}', [PaymentController::class, 'apiStore']);
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});


// Protected routes - Admin
Route::middleware(['auth:sanctum', 'rolemanager:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        // Dashboard stats
        Route::get('/dashboard', [AdminMainController::class, 'dashboard']);
        
        // Category management
        Route::apiResource('categories', CategoryController::class)->except(['index']);
        
        // Product management  
        Route::apiResource('products', ProductController::class)->except(['index', 'show']);
        
        // User management
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
        
        // Order management
        Route::get('/orders', [OrderController::class, 'adminIndex']);
        Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
    });
});


