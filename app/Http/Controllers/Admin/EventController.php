<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventCelebrity;
use App\Models\EventPass;
use App\Models\EventCategory;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    public function index()
    {
        return view('admin.event');
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
        $columns = ['events.id', 'event_categories.name', 'events.image', 'events.title', 'events.address', 'events.start_date', 'events.end_date'];

        $query = Event::join('event_categories', 'event_categories.id', '=', 'events.category_id')
            ->select('events.*', 'event_categories.name as category_name');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('event_categories.name', 'like', "%{$search}%")
                ->orWhere('events.title', 'like', "%{$search}%")
                ->orWhere('events.address', 'like', "%{$search}%");
            });
        }
       
        $query = $query->orderBy($columns[$orderColumn], $orderDir);


        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = Event::count();
        $filteredRecords = count($filtertotalget);

       
        $i =  $request->get('start');
        $data = array();
        foreach($users as $val){
           $i++;

           $checked = '';
           if($val->status == 1){
               $checked = 'checked';
           }

            $status = '<label class="switch"><input type="checkbox" '.$checked.' onchange="changestatus('.$val->id.')"><span class="slider"></span></label>';

           

           $imagepath = $val->event_image 
           ? asset('uploads/event/' . $val->event_image) 
           : asset('images/logo.png');


            $uimage = '<img class="status-img" src="' . $imagepath .'" alt="'.$val->icon.'" style="width:40px;">';


            $action = '
            <a class="btn btn-link mybtn" href="' . route('admin.event_view', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-eye" style="color:#007bff!important;" title="View"></i>
                        </a>

               <a class="btn btn-link mybtn" href="' . route('admin.event_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
            <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['category'] = $val->category_name ?? '';
            $sub_array['image'] = $uimage ?? '';
            $sub_array['title'] = $val->title ?? '';
            $sub_array['address'] = $val->address;
            $sub_array['start_date'] = \Carbon\Carbon::parse($val->start_date)->format('d, M Y');
            $sub_array['end_date'] = \Carbon\Carbon::parse($val->end_date)->format('d, M Y');
            $sub_array['status'] = $status;
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

     public function add_event(){
        $category = EventCategory::where('name','!=','All')->where('status','1')->orderBy('rank', 'asc')->get();
        return view('admin.add_event',compact('category'));
    }

    public function insert_event(Request $request){

        $eventdata = Event::where('title',$request->title)->first();
        if($eventdata){
             return response()->json([
                'status' => 'error',
                'message' => 'Event already added',
            ]);
        }
        
        $event_image_name = '';
        $pass_pdf_name = '';
        $organizer_image_name = '';

        $sdate = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
        $edate = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');
        $time = \Carbon\Carbon::createFromFormat('H:i', $request->time)->format('h:i A');



        if ($request->hasFile('event_image')) {
            $file = $request->file('event_image');
            $event_image_name = 'event_'.time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/event'), $event_image_name);
        }

        if ($request->hasFile('pass_pdf')) {
            $file2 = $request->file('pass_pdf');
            $pass_pdf_name = 'pass_'.time() . '-' . $file2->getClientOriginalName();
            $file2->move(public_path('uploads/event'), $pass_pdf_name);
        }

        if ($request->hasFile('organizer_image')) {
            $file3 = $request->file('organizer_image');
            $organizer_image_name = 'organizer_'.time() . '-' . $file3->getClientOriginalName();
            $file3->move(public_path('uploads/event'), $organizer_image_name);
        }


        $event = new Event;
        $event->category_id  = $request->category_id;
        $event->event_image  = $event_image_name;
        $event->title  = $request->title;
        $event->address  = $request->address;
        $event->start_date  = $sdate;
        $event->end_date  = $edate;
        $event->time  = $time;
        $event->description  = $request->description;
        $event->organizer_image  = $organizer_image_name;
        $event->organizer_name  = $request->organizer_name;
        $event->contact_no  = $request->contact_no;
        $event->pass_pdf  = $pass_pdf_name;
        $event->latitude  = $request->latitude;
        $event->longitude  = $request->longitude;
        $event->save();

        if ($request->has('celebrities')) {
            foreach ($request->celebrities['name'] as $key => $name) {
                if (!empty($name)) {
                    $celebrity = new EventCelebrity();
                    $celebrity->event_id = $event->id;
                    $celebrity->name = $name;

                    if (isset($request->celebrities['image'][$key])) {
                        $imageFile = $request->celebrities['image'][$key];
                        $imgName = 'cel_' . time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                        $imageFile->move(public_path('uploads/event'), $imgName);
                        $celebrity->image = $imgName;
                    }

                    $celebrity->save();
                }
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.event'),
        ]);
    }

    public function update_event(Request $request){
        

        $event = Event::find($request->id);


        $eventdata = Event::where('title',$request->title)->where('id','!=',$request->id)->first();
        if($eventdata){
             return response()->json([
                'status' => 'error',
                'message' => 'Event already added',
            ]);
        }



        $sdate = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
        $edate = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');
        $time = \Carbon\Carbon::createFromFormat('H:i', $request->time)->format('h:i A');



        if ($request->hasFile('event_image')) {
            $filePath = public_path('uploads/event/'.$event->event_image);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $file = $request->file('event_image');
            $event_image_name = 'event_'.time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/event'), $event_image_name);
            $event->event_image  = $event_image_name;
        }

        if ($request->hasFile('pass_pdf')) {
            $filePath2 = public_path('uploads/event/'.$event->pass_pdf);
            if (File::exists($filePath2)) {
                File::delete($filePath2);
            }


            $file2 = $request->file('pass_pdf');
            $pass_pdf_name = 'pass_'.time() . '-' . $file2->getClientOriginalName();
            $file2->move(public_path('uploads/event'), $pass_pdf_name);
            $event->pass_pdf  = $pass_pdf_name;
        }

        if ($request->hasFile('organizer_image')) {
            $filePath3 = public_path('uploads/event/'.$event->organizer_image);
            if (File::exists($filePath3)) {
                File::delete($filePath3);
            }

            $file3 = $request->file('organizer_image');
            $organizer_image_name = 'organizer_'.time() . '-' . $file3->getClientOriginalName();
            $file3->move(public_path('uploads/event'), $organizer_image_name);
            $event->organizer_image  = $organizer_image_name;
        }


        $event->category_id  = $request->category_id;
        $event->title  = $request->title;
        $event->address  = $request->address;
        $event->start_date  = $sdate;
        $event->end_date  = $edate;
        $event->time  = $time;
        $event->description  = $request->description;
        $event->organizer_name  = $request->organizer_name;
        $event->contact_no  = $request->contact_no;
        $event->latitude  = $request->latitude;
        $event->longitude  = $request->longitude;
        $event->save();


        if ($request->has('celebrities')) {
            foreach ($request->celebrities['name'] as $key => $name) {
                if (!empty($name)) {
                    $celebrity = new EventCelebrity();
                    $celebrity->event_id = $request->id;
                    $celebrity->name = $name;

                    if (isset($request->celebrities['image'][$key])) {
                        $imageFile = $request->celebrities['image'][$key];
                        $imgName = 'cel_' . time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                        $imageFile->move(public_path('uploads/event'), $imgName);
                        $celebrity->image = $imgName;
                    }

                    $celebrity->save();
                }
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.event'),
        ]);
    }

     public function event_edit($id){
        $event = Event::where('id',$id)->first();
        $category = EventCategory::where('name','!=','All')->where('status','1')->orderBy('rank', 'asc')->get();
        $celebrities = EventCelebrity::where('event_id',$id)->get();
        return view('admin.edit_event',compact('event','category','celebrities'));
    }


    public function event_view($id){
        $event = Event::where('id',$id)->first();
        $event_celebrities = EventCelebrity::where('event_id',$id)->get();
        $event_passes = EventPass::where('event_id',$id)->get();

        return view('admin.view_event',compact('event','event_celebrities','event_passes'));
    }

     public function event_status_change(Request $request){
        $userdata = Event::find($request->id);

        if($userdata['status'] == '0'){
            $userdata->status = '1';
        }else{
            $userdata->status = '0';
        }
        
         $userdata->save();

         return response()->json([
            'status' => 'success',
            'msg' => 'status change success',
        ]);
    }

    public function event_delete(Request $request){
        $userdata = Event::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }

    public function celebrity_delete(Request $request){
        $userdata = EventCelebrity::find($request->id);

         $filePath3 = public_path('uploads/event/'.$userdata->image);
        if (File::exists($filePath3)) {
            File::delete($filePath3);
        }


        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }
}
