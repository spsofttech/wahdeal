<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_address_id',
        'coupon_code_id',
        'transaction_id',
        'transaction_response',
        'order_number',
        'total',
        'charge',
        'payment_method',
        'payment_status',
        'order_status',
        'cancel_reason_id',
        'cancel_note'
    ];



    protected $appends = ['order_status_text','payment_method_text'];

    public function getOrderStatusTextAttribute()
    {
        $types = [
            1 => 'Confirmed',
            2 => 'Shipped',
            3 => 'On the Way',
            4 => 'Delivered',
            5 => 'Cancelled',
            6 => 'Return', 
            7 => 'Complete'
        ];

        return $types[$this->attributes['order_status'] ?? null] ?? '';
    }

    public function getPaymentMethodTextAttribute()
    {
        $methods = [
            1 => 'Cash On Delivery',
            2 => 'Online',
            3 => 'Wallet',
        ];

        return $methods[$this->attributes['payment_method'] ?? null] ?? '';
    }

    public static function statusList()
    {
        return [
            1 => 'Confirmed',
            2 => 'Shipped',
            3 => 'On the Way',
            4 => 'Delivered',
            5 => 'Cancelled',
            6 => 'Return',
            7 => 'Complete'
        ];
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id');
    }


}
