<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Brand extends Authenticatable
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'email',
        'password',
        'category_id',
        'subcategory_id',
        'name',
        'icon',
        'banner_image',
        'description',
        'website',
        'veg_nonveg',
        'is_promote',
        'status'
    ];

    protected $appends = ['image_url','banner_image_url'];


    public function getImageUrlAttribute()
    {
        if (!$this->icon) {
            return '';
        }
        return asset('uploads/brand/' . $this->icon);
    }

    public function getBannerImageUrlAttribute()
    {
        if (!$this->banner_image) {
            return '';
        }
        return asset('uploads/brand/' . $this->banner_image);
    }

     public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class, 'brand_id');
    }
}