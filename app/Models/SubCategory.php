<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'subcategories';

    protected $fillable = [
        'category_id',
        'name',
        'icon',
        'gst',
        'rank',
        'description',
        'status',
    ];

    protected $appends = ['image_url'];


    public function getImageUrlAttribute()
    {
        if (!$this->icon) {
            return '';
        }
        return asset('uploads/subcategory/' . $this->icon);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brands()
    {
        return $this->hasMany(Brand::class, 'subcategory_id', 'id')
                    ->where('status', '1')
                    ->orderBy('id');
    }
}