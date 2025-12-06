<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSizeColorPrice extends Model
{
    use HasFactory;


    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'price',
    ];

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }



}
