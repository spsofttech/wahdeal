<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category');
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

        $query = Category::where('name','!=', 'All')->select('*');

        if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }
       
        $query = $query->orderBy('rank', 'asc');

        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = Category::where('name','!=', 'All')->count();
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
               <a class="btn btn-link mybtn" href="' . route('admin.category_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
            <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            if($val->is_fashion == '0'){
                $type = 'Offline';
            }else if($val->is_fashion == '1'){
                $type = 'Online';
            }else{
                $type = 'Both';
            }  
            
            if($val->is_booking == '1'){
                $is_booking = 'Yes';
            }else{
                $is_booking = 'No';
            } 
            
            if($val->is_appointment == '1'){
                $is_appointment = 'Yes';
            }else{
                $is_appointment = 'No';
            } 

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['id'] = $val->id;
            $sub_array['name'] = $val->name;
            $sub_array['icon'] = $uimage;
            $sub_array['type'] = $type;
            $sub_array['is_booking'] = $is_booking;
            $sub_array['is_appointment'] = $is_appointment;
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
                Category::where('id', $item['id'])->update(['rank' => $rank]);
            }
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }

    public function add_category(){
        return view('admin.add_category');
    }

    public function insert_category(Request $request){

        $fileName = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/category'), $fileName);
        }


        $newCategory = new Category;
        $newCategory->name = $request->name;
        $newCategory->icon = $fileName;
        $newCategory->is_fashion = $request->is_fashion;
        $newCategory->is_booking = $request->is_booking;
        $newCategory->is_appointment = $request->is_appointment;
        


        $newCategory->rank = Category::max('rank') + 1;
        $newCategory->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.category'),
        ]);
    }

    public function category_edit($id){
        $category = Category::where('id',$id)->first();
        return view('admin.edit_category',compact('category'));
    }

    public function update_category(Request $request){

        $user = Category::find($request->id);

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
        $user->is_fashion = $request->is_fashion;
        $user->is_booking = $request->is_booking;
        $user->is_appointment = $request->is_appointment;
        $user->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.category'),
        ]);
    }

    public function category_status_change(Request $request){
        $userdata = Category::find($request->id);

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
        $userdata = Category::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }

}
