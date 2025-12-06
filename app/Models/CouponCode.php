<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'discount_type',
        'discount_value',
        'end_date',
        'usage_limit',
        'type',
        'type',
        'status'
    ];

    protected $appends = ['image_url'];


    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return '';
        }
         return asset('uploads/coupon/' . $this->image);
    }
}
