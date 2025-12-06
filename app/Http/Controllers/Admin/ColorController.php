<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
     public function index()
    {
        return view('admin.color');
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
        $columns = ['id','name','color_code'];

        $query = Color::select('*');

        if ($search) {
                $query->where(function ($q) use ($search) {
                     $q->where('name', 'like', "%{$search}%")
                     ->orWhere('color_code', 'like', "%{$search}%");
                });
        }
       
        $query = $query->orderBy($columns[$orderColumn], $orderDir);


        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = Color::count();
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

            $action = '
               <a class="btn btn-link mybtn" href="' . route('admin.color_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
            <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['name'] = $val->name;
            $sub_array['color_code'] = $val->color_code;
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

    public function add_color(){
        return view('admin.add_color');
    }

    public function insert_color(Request $request){

        $colordata = Color::where('color_code',$request->color_code)->first();
        if($colordata){
             return response()->json([
                'status' => 'error',
                'message' => 'Color already added',
            ]);
        }

        $color = new Color;
        $color->name = $request->name;
        $color->color_code = $request->color_code;
        $color->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.color'),
        ]);
    }

    public function color_edit($id){
        $color = Color::where('id',$id)->first();    
        return view('admin.edit_color',compact('color'));
    }

     public function update_color(Request $request){

        $colordata = Color::where('color_code',$request->color_code)->where('id','!=',$request->id)->first();
        if($colordata){
             return response()->json([
                'status' => 'error',
                'message' => 'Color already added',
            ]);
        }

        $color = Color::where('id',$request->id)->first();
        $color->name = $request->name;
        $color->color_code = $request->color_code;
        $color->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.color'),
        ]);
    }

    public function color_status_change(Request $request){
        $userdata = Color::find($request->id);

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

    public function color_delete(Request $request){
        $userdata = Color::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }
}
