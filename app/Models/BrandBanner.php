<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'product_id',
        'own_banner',
        'launch_type',
        'type',
        'image',
        'website',
        'title',
        'subtitle',
        'status',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return '';
        }
         return asset('uploads/brand/' . $this->image);
    }
}