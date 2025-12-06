<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
    ];

    public static function totalCount($product_id)
    {
        $count = self::where('product_id', $product_id)->count();
        return $count;
    }
}
