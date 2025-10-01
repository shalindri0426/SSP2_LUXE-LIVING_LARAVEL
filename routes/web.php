<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\AdminMainController;
use App\Http\Controllers\User\UserMainController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WishlistController;
use Laravel\Fortify\Features;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//admin routes
Route::middleware(['auth:sanctum', 'verified','rolemanager:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::controller(AdminMainController::class)->group(function () {
            Route::get('/dashboard','index')->name('admin');
            Route::get('/cart','cart')->name('admin.cart');
            Route::get('/category/create','ccindex')->name('category.create');
            Route::get('/category/manage','cmanage')->name('category.manage');
            Route::get('/product/create','pcindex')->name('product.create');
            Route::get('/product/manage','pmanage')->name('product.manage');
            Route::get('/user/manage','umanage')->name('user.manage');



        }); 

        Route::controller(CategoryController::class)->group(function () {
            Route::post('/add/category','addcat')->name('add.category');
            Route::get('/category/{id}','showcat')->name('show.category');
            Route::put('/category/update/{id}','updatecat')->name('update.category');
            Route::delete('/category/delete/{id}','deletecat')->name('delete.category');
        }); 

        Route::controller(ProductController::class)->group(function () {
            Route::post('/add/product','addproduct')->name('add.product');
            Route::get('/product/{id}','showproduct')->name('show.product');
            Route::put('/product/update/{id}','updateproduct')->name('update.product');
            Route::delete('/product/delete/{id}','deleteproduct')->name('delete.product');
        }); 

        Route::controller(UserController::class)->group(function () {
            Route::get('/user/{id}','showuser')->name('show.user');
            Route::delete('/user/delete/{id}','deleteuser')->name('delete.user');
        }); 

        Route::controller(OrderController::class)->group(function(){
            Route::get('/order','showOrders')->name('admin.order');
        });
    });    
});


//cutomer routes
Route::middleware(['auth:sanctum', 'verified','rolemanager:customer'])->group(function () {
    Route::prefix('customer')->group(function () {
        Route::controller(ProductController::class)->group(function () {
            Route::get('/dashboard','index')->name('user.user');
            Route::get('/products/{product}','show')->name('user.show');

            //cart and order routes
            Route::post('/products/{product}/add-to-cart','addToCart')->name('user.add-to-cart');
            Route::post('/products/{product}/but-now','buyNow')->name('user.buy-now');
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::get('/category/{id}/products','showCategoryProducts')->name('user.category.products');
        });

        Route::controller(CartController::class)->group(function(){
            Route::get('/cart','viewCart')->name('cart.view');
            Route::post('/cart/add','addToCart')->name('cart.add');
            Route::delete('/cart/remove','removeFromCart')->name('cart.remove');
            Route::patch('/cart/update','updateQuantity')->name('cart.update');
            Route::get('/cart/count','getCartCount')->name('cart.count');
            Route::delete('/cart/clear','clearCart')->name('cart.clear'); 

        });

        Route::controller(OrderController::class)->group(function(){
            Route::get('/checkout','checkout')->name('orders.checkout');
            Route::post('/orders','store')->name('orders.store');
            Route::get('/orders/{order}/payment','payment')->name('orders.payment');
            Route::get('/orders','orders')->name('orders.index');

        });

        Route::controller(PaymentController::class)->group(function(){
            Route::post('/orders/{order}/payment','store')->name('payments.store');
            Route::get('/orders/{order}/success','success')->name('orders.success');
        });

        Route::controller(WishlistController::class)->group(function(){
            Route::post('/wishlist/add','add')->name('wishlist.add');
            Route::get('/wishlist/count', 'count')->name('wishlist.count');
            Route::get('/wishlist','index')->name('wishlist.index');
            Route::get('/wishlist/check/{product_id}', 'check')->name('wishlist.items');
            Route::delete('/wishlist/remove/{product_id}','remove')->name('wishlist.remove');
        });
    });    
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/wishlist/test', function() {
    return response()->json(['status' => 'Routes are working']);
});
require __DIR__.'/auth.php';
