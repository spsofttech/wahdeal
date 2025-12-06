<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'branch_id',
        'image',
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
