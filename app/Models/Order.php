<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'products',
        'total_amount',
        'delivery_address',
        'delivery_phone',
        'delivery_name',
        'special_instructions',
        'order_status',
        'payment_status'
    ];

    protected $casts = [
        'products' => 'array',
        'total_amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Generate unique order ID
    public static function generateOrderId()
    {
        do {
            $orderId = 'ORD-' . strtoupper(uniqid());
        } while (self::where('order_id', $orderId)->exists());
        
        return $orderId;
    }
}
