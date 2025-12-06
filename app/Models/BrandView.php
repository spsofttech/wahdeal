<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandView extends Model
{
    use HasFactory;


     protected $fillable = [
        'brand_id',
        'user_id',
    ];

    public static function totalCount($brandid)
    {
        $count = self::where('brand_id', $brandid)->count();
        return $count;
    }

}
