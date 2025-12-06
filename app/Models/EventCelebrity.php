<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCelebrity extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'image',
        'name',
    ];

    protected $appends = ['image_url'];


    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return '';
        }
         return asset('uploads/event/' . $this->image);
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
