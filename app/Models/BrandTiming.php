<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandTiming extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'branch_id',
        'day',
        'open_time',
        'close_time',
        'status',
    ];
}