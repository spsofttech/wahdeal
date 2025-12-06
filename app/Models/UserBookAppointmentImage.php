<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBookAppointmentImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_book_appointment_id',
        'category_field_id',
        'image'
    ];

    protected $appends = ['image_url'];


    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return '';
        }
        return asset('uploads/booking/' . $this->image);
    }

}
