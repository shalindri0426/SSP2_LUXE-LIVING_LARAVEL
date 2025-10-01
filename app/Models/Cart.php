<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors
    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rs. ' . number_format($this->price, 2);
    }

    public function getFormattedTotalPriceAttribute()
    {
        return 'Rs. ' . number_format($this->total_price, 2);
    }

    // Static methods
    public static function getCartTotal($userId)
    {
        return self::where('user_id', $userId)->sum(\DB::raw('price * quantity'));
    }

    public static function getCartCount($userId)
    {
        return self::where('user_id', $userId)->sum('quantity');
    }

}
