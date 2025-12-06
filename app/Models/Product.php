<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
     use HasFactory,SoftDeletes;

       protected $fillable = [
        'category_id',
        'subcategory_id',
        'brand_id',
        'name',
        'description',
        'disclaimer',
        'price',
        'gst',
        'image',
        'veg_nonveg',
        'is_promote',
        'is_fashion',
        'is_cart_cancel_product',
        'status'
    ];

    protected $appends = ['image_url'];


    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return '';
        }
         return asset('uploads/product/' . $this->image);
    }

     public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function offer()
    {
        return $this->hasOne(Offer::class, 'product_id', 'id');
    }
    

}