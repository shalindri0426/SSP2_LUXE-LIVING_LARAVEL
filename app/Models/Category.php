<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name'
    ];

    // Relationship with Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Get active products in this category
    public function activeProducts()
    {
        return $this->hasMany(Product::class)->where('is_active', true);
    }

    // Get products count for this category
    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }

    // Get active products count for this category
    public function getActiveProductsCountAttribute()
    {
        return $this->activeProducts()->count();
    }
}
