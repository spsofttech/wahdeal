<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
use App\Models\UserLocation;
use App\Models\ShortLink;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $rules = [
            'page' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $page = $request->page ?? 1;
        $limit = env('PAGINATION_LIMIT', 10);
        $start = ($page - 1) * $limit;


         $user = Auth::guard('api')->user();

         if($user){
             $uid = $user->id;
             $location = UserLocation::where('user_id',$uid)->where('status','1')->first();

             if($location){
                $update['state']= $location->state;
                $update['city']= $location->city;
                $update['latitude']= $location->latitude;
                $update['longitude'] = $location->longitude;
                User::where('id', $user->id)->update($update);
             }

            $userdata = User::where('id',$user->id)->select('first_name','last_name','image','state','city','latitude','longitude','promo_code','wallet_balance')->first();
        }else{
            $uid = '0';
            $userdata = (object) [];
        }

        if($uid != '0'){
            $user_lat = $userdata->latitude;
            $user_long = $userdata->longitude;
        }else{
             $userlatitude = getstaticlatlong();
            $user_lat = $userlatitude['lat'];
            $user_long = $userlatitude['long'];
        }



         $category = EventCategory::where('status', '1')
                    ->orderBy('rank', 'asc')
                    ->get()
                    ->map(function ($cat) {
                        if ($cat->name === 'All') {
                            $cat->events_count = Event::where('status', '1')->count();
                        } else {
                            $cat->events_count = Event::where('status', '1')
                                ->where('category_id', $cat->id)
                                ->count();
                        }
                        return $cat;
                    });


        $events = Event::select('*', DB::raw("
                    (6371 * acos(
                        cos(radians($user_lat)) *
                        cos(radians(latitude)) *
                        cos(radians(longitude) - radians($user_long)) +
                        sin(radians($user_lat)) *
                        sin(radians(latitude))
                    )) AS distance
                "))
                ->where('status', '1')
                ->orderBy('distance', 'asc');

        if (!empty($request->category_id)) {
            $events->where('category_id', $request->category_id);
        }


        if (!empty($request->date_type)) {
            $today = Carbon::today();

            $startOfWeek = $today->startOfWeek(); 
            $endOfWeek = $today->endOfWeek();     

            $startOfWeek = $today->startOfWeek()->toDateString();
            $endOfWeek = $today->endOfWeek()->toDateString(); 


            switch ($request->date_type) {
                case '2':
                    $events->whereDate('start_date', $today);
                    break;
                case '3':
                    $events->whereDate('start_date', $today->copy()->addDay());
                    break;
                case '4':
                    $events->whereBetween('start_date', [$startOfWeek, $endOfWeek]);
                    break;
                case '1':
                    break;

                case '5':
                if ($request->filled('start_date') && $request->filled('end_date')) {
                        $events->where(function($query) use ($request) {
                            $query->where('start_date', '<=', $request->end_date)
                                ->where('end_date', '>=', $request->start_date);
                        });
                    }
                    break;

                default:
                    break;
            }
        }

      

        $all_data = $events->get();
        $pagination_data = $events->orderBy('start_date', 'asc')
            ->skip($start)
            ->take($limit)
            ->get();

           
        $count = count($all_data);
        $total_page = ceil($count / $limit);
        $is_nextpage = ($total_page > $page) ? '1' : '0';

        $data['category'] =  $category;
        $data['date_filters'] = Event::dateFilters();
        $data['event'] =  $pagination_data;
        $data['user'] =  $userdata;
        $data['is_blur'] = is_blur($uid);
        

        return sendResponsePagination($data, 'Data Fetch Successfully.', $is_nextpage);
    }

    public function event_detail(Request $request)
    {
        $rules = [
            'id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();
        $id = $request->id;
       
        
        $event = Event::where('id',$id)->first();

        if(!$event){
            return sendError(array(), 'Event not exists'); 
        }

        $event->event_celebrity = EventCelebrity::where('event_id',$id)->get();
        $event->event_pass = EventPass::where('event_id',$id)->get();


        $e_link = ShortLink::where('type','event')->where('item_id',$id)->first();
        $event->event_website = url("/d/{$e_link->code}");


        return sendResponse($event, 'Data fetch successfully.');
        
    }


    public function event_ticket(Request $request)
    {
        $rules = [
            'id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'event_data' => 'required',
            'payment_link' => 'required',
            'total' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();
        $id = $request->id;
       
        $event = Event::where('id',$id)->first();

        if(!$event){
            return sendError(array(), 'Event not exists'); 
        }

        $usereventticketdata = array(
                "user_id"=>$user->id,
                "event_id"=>$id,
                "first_name"=>$request->first_name,
                "last_name" => $request->last_name,
                "email" => $request->email,
                "mobile" => $request->mobile,
            );

        $usereventticket = UserEventTicket::create($usereventticketdata);

         if(!empty($request->event_data)){
                $event_data = is_array($request->event_data) ? $request->event_data : json_decode($request->event_data, true);
                
                foreach ($event_data['eventdata'] as  $val) {
                    $odata['user_event_ticket_id'] = $usereventticket->id;
                    $odata['day'] =  $val['day'];
                    $odata['card'] = $val['card'];
                    $odata['price'] = $val['price'];
                    $odata['event_date'] = $val['date'];
                    $odata['total'] = $val['total'];
                    UserEventTicketHistory::create($odata);
                }
            }


        $payment_data = array(
            "type"=>'event',
            "user_id"=>$user->id,
            "user_event_ticket_id"=>$usereventticket->id,
            "payment_id" => $request->payment_link,
            "total" => $request->total,
            "transaction_type" => 'debit'
        );

        UserTransaction::create($payment_data);

        return sendResponse(array(), 'Payment successfully.');
    }

}
