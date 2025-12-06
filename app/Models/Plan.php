<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

     protected $fillable = [
        'title',
        'month',
        'old_amount',
        'latest_amount',
        'discount_text'
    ];

}
