<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
   use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'event_image',
        'title',
        'address',
        'start_date',
        'end_date',
        'time',
        'description',
        'organizer_image',
        'organizer_name',
        'contact_no',
        'pass_pdf',
        'latitude',
        'longitude',
        'status'
    ];


   public static function dateFilters()
    {
        return [
            ['value' => '1', 'label' => 'Any Date'],
            ['value' => '2', 'label' => 'Today'],
            ['value' => '3', 'label' => 'Tomorrow'],
            ['value' => '4', 'label' => 'This Week'],
            
        ];
    }



    protected $appends = ['image_url','organizer_image_url','pdf_url'];


    public function getImageUrlAttribute()
    {
        if (!$this->event_image) {
            return '';
        }
         return asset('uploads/event/' . $this->event_image);
    }

    public function getOrganizerImageUrlAttribute()
    {
        if (!$this->organizer_image) {
            return '';
        }
         return asset('uploads/event/' . $this->organizer_image);
    }

    public function getPdfUrlAttribute()
    {
        if (!$this->pass_pdf) {
            return '';
        }
         return asset('uploads/event/' . $this->pass_pdf);
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id', 'id');
    }

    public function celebrities()
    {
        return $this->hasMany(EventCelebrity::class, 'event_id');
    }

    public function passes()
    {
        return $this->hasMany(EventPass::class, 'event_id');
    }



}
