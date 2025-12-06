<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;


     protected $fillable = [
        'order_id',
        'product_id',
        'branch_id',
        'offer_id',
        'size_id',
        'color_id',
        'quantity',
        'price',
        'gst',
        'gst_price',
        'discount',
        'final_price',
        'order_status'
    ];


    protected $appends = ['cart_status_text'];

    public function getCartStatusTextAttribute()
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

     public static function cancelreasonList()
    {
        return [
            "Wrong item selected",
            "Ordered by mistake",
            "Found cheaper",
            "Changed mind",
            "Other"
        ];
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

}
