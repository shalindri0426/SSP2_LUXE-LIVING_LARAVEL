<?php

namespace App\Models;

//use MongoDB\Laravel\Eloquent\Model;

class Wishlist extends Model
{
    //protected $connection='mongodb';
    protected $collection='wishlist';

    protected $fillable=[
        'user_id',
        'product_id',
        
    ];

    protected $casts=[
        'user_id' => 'integer',
        'product_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    //get product from mysql
    public function product(){
        return $this->belongsTo(\App\Models\Product::class,'product_id');
    }

    //get user from mysql
    public function user(){
        return $this->belongsTo(\App\Models\User::class,'user_id');
    }

    public static function addToWishlist($userId, $productId)
    {
        return self::firstOrCreate([
            'user_id' => (int)$userId,
            'product_id' => (int)$productId,
        ]);
    }

    public static function removeFromWishlist($userId, $productId)
    {
        return self::where('user_id', (int)$userId)
            ->where('product_id', (int)$productId)
            ->delete();
    }

    public static function isInWishlist($userId, $productId)
    {
        return self::where('user_id', (int)$userId)
            ->where('product_id', (int)$productId)
            ->exists();
    }
}
