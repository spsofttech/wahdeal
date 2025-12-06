<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'review'
    ];

    public static function totalRating($productId)
    {
        $total = self::where('product_id', $productId)->sum('rating');
        $count = self::where('product_id', $productId)->count();

        if ($count === 0) {
            return 0;
        }

        return round($total / $count, 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}