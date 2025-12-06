<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\EventCategory;
use App\Models\Event;
use App\Models\EventCelebrity;
use App\Models\EventPass;
use App\Models\UserEventTicket;
use App\Models\UserEventTicketHistory;
use App\Models\UserTransaction;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('api')->user();

        $transactions = UserTransaction::with([
            'userEventTicket.event:id,title,event_image,organizer_image,start_date,end_date,time,address,latitude,longitude',
            'userEventTicket.histories:id,user_event_ticket_id,day,card,price,event_date,total',
            'referUser:id,first_name,last_name,image',
            'plan:id,title,month,old_amount,latest_amount,discount_text'
        ])
        ->where('user_id', $user->id)
        ->orderBy('id', 'desc')
        ->get()
        ->map(function ($transaction) {
            $transactionArray = $transaction->toArray();
            $transactionArray['refer_user'] = $transaction->referUser 
                ? [
                    'id' => $transaction->referUser->id,
                    'first_name' => $transaction->referUser->first_name,
                    'last_name' => $transaction->referUser->last_name,
                    'image' =>  asset('uploads/user/' . $transaction->referUser->image),
                ] 
                : (object) [];

            $transactionArray['plan'] = $transaction->plan 
                ? $transaction->plan  
                : (object) [];    
            return $transactionArray;
        });

        return sendResponse($transactions, 'Data fetched successfully.');
    }

     public function purchase_history(Request $request)
    {
        $user = Auth::guard('api')->user();

        $transactions = UserTransaction::with([
            'userEventTicket.event:id,title,event_image,organizer_image,pass_pdf,start_date,end_date,time,address,latitude,longitude',
            'userEventTicket.histories:id,user_event_ticket_id,day,card,price,event_date,total'
        ])
        ->where('user_id', $user->id)
        ->where('type', 'event')
        ->orderBy('id', 'desc')
        ->get();

        return sendResponse($transactions, 'Data fetched successfully.');
    }

}
