<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBookAppointment extends Model
{
    use HasFactory, SoftDeletes;

       protected $fillable = [
        'user_id',
        'brand_id',
        'branch_id',
        'is_booking_appointment',
        'form_data',
        'book_status',
        'booking_cancel_reason_id',
        'booking_cancel_reason_other'
    ];


    protected $appends = ['book_status_text'];

    public function getBookStatusTextAttribute()
    {
        $types = [
            0 => 'Pending',
            1 => 'Complete',
            2 => 'Confirmed',
            3 => 'Cancelled',
            4 => 'Rejected'
        ];

        return $types[$this->attributes['book_status'] ?? null] ?? '';
    }

    public static function statusList()
    {
        return [
            0 => 'Pending',
            1 => 'Complete',
            2 => 'Confirmed',
            3 => 'Cancelled',
            4 => 'Rejected'
        ];
    }

    public function cancelReason()
    {
        return $this->belongsTo(BookingCancelReason::class, 'booking_cancel_reason_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
