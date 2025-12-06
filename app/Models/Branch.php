<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Branch extends Authenticatable
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'brand_id',
        'about',
        'email',
        'state',
        'city',
        'area',
        'pincode',
        'contact_no',
        'whatsapp_no',
        'otp',
        'address',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'pinterest',
        'latitude',
        'longitude',
        'is_booking',
        'is_appointment',
        'status'
    ];


}