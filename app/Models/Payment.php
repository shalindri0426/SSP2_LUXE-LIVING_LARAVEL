<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'receipt_pdf',
        'card_number',
        'exp_date',
        'cvv',
        'card_holder_name',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Encrypt card number for security
    public function setCardNumberAttribute($value)
    {
        if ($value) {
            $this->attributes['card_number'] = encrypt($value);
        }
    }

    public function getCardNumberAttribute($value)
    {
        if ($value) {
            return decrypt($value);
        }
        return $value;
    }
}
