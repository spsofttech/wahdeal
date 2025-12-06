<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventCategory extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'icon',
        'rank',
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
}
