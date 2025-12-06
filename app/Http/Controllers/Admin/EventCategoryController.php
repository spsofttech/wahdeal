<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventCategory;
use Illuminate\Support\Facades\File;

class EventCategoryController extends Controller
{
    public function index()
    {
        return view('admin.event_category');
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

        $query = EventCategory::where('name','!=', 'All')->select('*');

        if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }
       
        $query = $query->orderBy('rank', 'asc');

        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = EventCategory::where('name','!=', 'All')->count();
        $filteredRecords = count($filtertotalget);

       
        $i =  $request->get('start');
        $data = array();
        foreach($users as $val){
           $i++;

           $imagepath = $val->icon 
           ? asset('uploads/category/' . $val->icon) 
           : asset('images/logo.png');


            $uimage = '<img class="status-img" src="' . $imagepath .'" alt="'.$val->icon.'" style="width:40px;">';

           $checked = '';
           if($val->status == 1){
               $checked = 'checked';
           }

            $status = '<label class="switch"><input type="checkbox" '.$checked.' onchange="changestatus('.$val->id.')"><span class="slider"></span></label>';
        
            $action = '
               <a class="btn btn-link mybtn" href="' . route('admin.event_category_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
            <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['id'] = $val->id;
            $sub_array['name'] = $val->name;
            $sub_array['icon'] = $uimage;
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

    public function category_reorder(Request $request)
    {
        $order = $request->input('order');

        if ($order && is_array($order)) {
            foreach ($order as $item) {
                $rank = $item['rank']+1;
                EventCategory::where('id', $item['id'])->update(['rank' => $rank]);
            }
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }

    public function add_event_category(){
        return view('admin.add_event_category');
    }

    public function insert_event_category(Request $request){

        $fileName = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/category'), $fileName);
        }


        $newCategory = new EventCategory;
        $newCategory->name = $request->name;
        $newCategory->icon = $fileName;
        $newCategory->rank = EventCategory::max('rank') + 1;
        $newCategory->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.event_category'),
        ]);
    }

    public function event_category_edit($id){
        $category = EventCategory::where('id',$id)->first();
        return view('admin.edit_event_category',compact('category'));
    }

    public function update_event_category(Request $request){

        $user = EventCategory::find($request->id);

        $fileName = '';
        if ($request->hasFile('image')) {
            $filePath = public_path('uploads/category/'.$user->icon);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }


            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/category'), $fileName);
            $user->icon = $fileName;
        }

        $user->name = $request->name;
        $user->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.event_category'),
        ]);
    }

    public function category_status_change(Request $request){
        $userdata = EventCategory::find($request->id);

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

    public function category_delete(Request $request){
        $userdata = EventCategory::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }
}
