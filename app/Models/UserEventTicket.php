<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEventTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'first_name',
        'last_name',
        'email',
        'mobile'
    ];

    public function histories()
    {
        return $this->hasMany(UserEventTicketHistory::class, 'user_event_ticket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
