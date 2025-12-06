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
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
