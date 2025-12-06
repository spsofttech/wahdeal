<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEventTicketHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_event_ticket_id',
        'day',
        'card',
        'price',
        'event_date',
        'total'
    ];
}
