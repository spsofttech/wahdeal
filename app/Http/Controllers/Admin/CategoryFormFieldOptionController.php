<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryFieldOption;

class CategoryFormFieldOptionController extends Controller
{
    public function index()
    {
        return view('admin.category_form_field_option');
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
        $columns = ['id', 'name'];

        $query = CategoryFieldOption::select('*');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
       
        $query = $query->orderBy($columns[$orderColumn], $orderDir);


        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = CategoryFieldOption::count();
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

           

            $action = '<a class="btn btn-link mybtn" href="' . route('admin.category_form_field_option_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
                        <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['name'] = $val->name ?? '';
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

    public function add_category_form_field_option(){
        return view('admin.add_category_form_field_option');
    }

    public function insert_category_form_field_option(Request $request){

        $CategoryFieldOptionData = CategoryFieldOption::where('name',$request->name)->first();
        if($CategoryFieldOptionData){
             return response()->json([
                'status' => 'error',
                'message' => 'Name already added',
            ]);
        }

        $CategoryFieldOption = new CategoryFieldOption;
        $CategoryFieldOption->name = $request->name;
        $CategoryFieldOption->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.category_form_field_option'),
        ]);
    }

     public function category_form_field_option_edit($id){
        $category_form_option = CategoryFieldOption::where('id',$id)->first();
        return view('admin.edit_category_form_field_option',compact('category_form_option'));
    }

    public function update_category_form_field_option(Request $request){

        $CategoryFieldOptionData = CategoryFieldOption::where('id','!=',$request->id)->where('name',$request->name)->first();
        if($CategoryFieldOptionData){
             return response()->json([
                'status' => 'error',
                'message' => 'Name already added',
            ]);
        }

        $CategoryFieldOption = CategoryFieldOption::where('id',$request->id)->first();
        $CategoryFieldOption->name = $request->name;
        $CategoryFieldOption->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.category_form_field_option'),
        ]);
    }


    public function category_form_field_option_status_change(Request $request){
        $userdata = CategoryFieldOption::find($request->id);

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

    public function category_form_field_option_delete(Request $request){
        $userdata = CategoryFieldOption::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }
}
