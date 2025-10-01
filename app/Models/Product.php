<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'product_name',
        'image',
        'price',
        'discount',
        'description',
        'material',
        'colour',
        'stock',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_active'=>'boolean'

    ];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship with cart
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    //Price currency
    public function getFormattedPriceAttribute(){
        return 'LKR'.number_format($this->price,2);
    }

    //stock qunantity
    public function isInStock(){
        return $this->stock>0;
    }

    // Get stock quantity
    public function getStockQuantityAttribute()
    {
        return $this->stock;
    }

    // Accessor for name (for compatibility with blade templates)
    public function getNameAttribute()
    {
        return $this->product_name;
    }

    // Scope for active products (you can add is_active column later if needed)
    public function scopeActive($query)
    {
        return $query; // For now, return all products
        // return $query->where('is_active', true); // Uncomment when you add is_active column
    }

    // Accessor to get discounted price
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount > 0) {
            return $this->price - ($this->price * $this->discount / 100);
        }
        return $this->price;
    }

    // Get formatted discounted price
    public function getFormattedDiscountedPriceAttribute()
    {
        return 'LKR ' . number_format($this->getDiscountedPriceAttribute(), 2);
    }

    // Check if product has discount
    public function hasDiscount()
    {
        return !is_null($this->discount) && $this->discount > 0;
    }

    // Scope for products with discounts
    public function scopeWithDiscount($query)
    {
        return $query->where('discount', '>', 0);
    }

    // Scope for available products (active and in stock)
    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)
                    ->where('stock', '>', 0);
    }

    // Relationship to MongoDB wishlists
    public function wishlist()
    {
        return $this->hasMany(\App\Models\Wishlist::class, 'product_id');
    }

    // Helper method
    public function wishlistedBy()
    {
        return $this->wishlists()->pluck('user_id');
    }
}
