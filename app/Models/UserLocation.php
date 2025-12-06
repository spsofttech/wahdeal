<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'city',
        'state',
        'latitude',
        'longitude',
        'address',
        'flat_no',
        'floor',
        'land_mark',
        'status'
    ];
}
