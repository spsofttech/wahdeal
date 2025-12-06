<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchProductRequest extends Model
{
    use HasFactory;

     protected $fillable = [
        'brand_id',
        'branch_id',
        'product_id',
        'about',
        'product',
        'product_images',
        'product_colors',
        'product_sizes',
        'product_size_color_prices',
        'offers',
        'status'
    ];
}
