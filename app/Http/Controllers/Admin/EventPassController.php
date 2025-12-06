<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventPass;

class EventPassController extends Controller
{
    public function index()
    {
        return view('admin.event_pass');
    }

    public function get_list(Request $request)
    {
      if ($request->ajax()) 
      {
        $start = $request->get('start', 0);
        $length = $request->get('length', 10); 
        $orderColumn = $request->input('order_column');
        $orderDir = $request->input('order_dir', 'asc');
        $search = $request->get('search')['value'];
        $columns = ['events.id', 'events.title', 'event_passes.day', 'event_passes.start_date', 'event_passes.time', 'event_passes.price'];

        $query = Event::join('event_passes', 'events.id', '=', 'event_passes.event_id')
            ->select('events.title', 'event_passes.*');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('events.title', 'like', "%{$search}%")
                ->orWhere('event_passes.day', 'like', "%{$search}%")
                ->orWhere('event_passes.price', 'like', "%{$search}%");
            });
        }
       
        $query = $query->orderBy($columns[$orderColumn], $orderDir);


        $filtertotalget =  $query->groupBy('events.id')->get();
        $users = $query->skip($start)->take($length)->groupBy('events.id')->get();


        $totalRecords = Event::count();
        $filteredRecords = count($filtertotalget);

       
        $i =  $request->get('start');
        $data = array();
        foreach($users as $val){
           $i++;

           

            $action = '
                        <a class="btn btn-link mybtn" href="' . route('admin.event_pass_edit', $val->event_id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['event'] = $val->title ?? '';
            $sub_array['day'] = $val->day ?? '';
            $sub_array['start_date'] = \Carbon\Carbon::parse($val->start_date)->format('d, M Y');
            $sub_array['time'] = $val->time ?? '';
            $sub_array['price'] = $val->price ?? '';
            $sub_array['action'] = $action;
            $data[] = $sub_array;
        }


        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
        }
    }

    public function add_event_pass(){
        $event = Event::where('status','1')->orderBy('id', 'desc')->get();
        return view('admin.add_event_pass',compact('event'));
    }

    public function insert_event_pass(Request $request){
        
        $exists = EventPass::where('event_id',$request->event_id)->first();
        if($exists){
             return response()->json([
                'status' => 'error',
                'message' => 'Data Already Added Please Update That Event Pass Records'
            ]);
        }

    
        if ($request->has('passes')) {
            foreach ($request->passes['day'] as $key => $day) {
                if (!empty($day)) {
                    $sdate = \Carbon\Carbon::parse($request->passes['start_date'][$key])->format('Y-m-d');
                    $time = \Carbon\Carbon::createFromFormat('H:i', $request->passes['time'][$key])->format('h:i A');

                    $pass = new EventPass();
                    $pass->event_id = $request->event_id;
                    $pass->day = $day;
                    $pass->start_date = $sdate;
                    $pass->time = $time;
                    $pass->price = $request->passes['price'][$key];
                    $pass->save();
                }
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.event_pass'),
        ]);
    }

    public function event_pass_edit($id){
        $passes = EventPass::where('event_id',$id)->get();
        $event = Event::where('status','1')->orderBy('id', 'desc')->get();
        return view('admin.edit_event_pass',compact('event','passes','id'));
    }

    public function update_event_pass(Request $request){
        
        if ($request->has('passes')) {
            foreach ($request->passes['day'] as $key => $day) {
                if (!empty($day)) {
                    $sdate = \Carbon\Carbon::parse($request->passes['start_date'][$key])->format('Y-m-d');
                    $time = \Carbon\Carbon::createFromFormat('H:i', $request->passes['time'][$key])->format('h:i A');

                    $pass = new EventPass();
                    $pass->event_id = $request->id;
                    $pass->day = $day;
                    $pass->start_date = $sdate;
                    $pass->time = $time;
                    $pass->price = $request->passes['price'][$key];
                    $pass->save();
                }
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.event_pass'),
        ]);
    }

    public function delete_event_pass(Request $request)
    {
        $pass = EventPass::find($request->id);

        if ($pass) {
            $pass->delete();
            return response()->json(['status' => 'success', 'message' => 'Pass deleted successfully.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Pass not found.']);
    }

}
