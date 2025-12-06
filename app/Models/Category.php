<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'icon',
        'rank',
        'is_fashion',
        'is_booking',
        'is_appointment',
        'status',
    ];

    protected $appends = ['image_url'];


    public function getImageUrlAttribute()
    {
        if (!$this->icon) {
            return '';
        }
         return asset('uploads/category/' . $this->icon);
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id')
                    ->where('status', '1')
                    ->orderBy('rank','asc');
    }

    public function brands()
    {
        return $this->hasMany(Brand::class, 'category_id', 'id')
                    ->where('status', '1')
                    ->orderBy('id');
    }
}