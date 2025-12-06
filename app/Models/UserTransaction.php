<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'user_id',
        'refer_by',
        'plan_id',
        'user_event_ticket_id',
        'payment_id',
        'total',
        'transaction_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function referUser()
    {
        return $this->belongsTo(User::class, 'refer_by');
    }

    public function userEventTicket()
    {
        return $this->belongsTo(UserEventTicket::class, 'user_event_ticket_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

}
