<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryFieldOption;
use App\Models\Category;
use App\Models\CategoryField;

class CategoryFormFieldController extends Controller
{
    public function index()
    {
        return view('admin.category_booking_form');
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
        $columns = ['categories.id', 'categories.name'];

        $query = CategoryField::join('categories', 'categories.id', '=', 'category_fields.category_id')
            
            ->select('categories.*');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('categories.name', 'like', "%{$search}%");
            });
        }
       
        $query = $query->groupBy('category_fields.category_id')->orderBy($columns[$orderColumn], $orderDir);


        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = CategoryField::join('categories', 'categories.id', '=', 'category_fields.category_id')->groupBy('category_fields.category_id')->count();
        $filteredRecords = count($filtertotalget);

       
        $i =  $request->get('start');
        $data = array();
        foreach($users as $val){
           $i++;

            $action = '
               <a class="btn btn-link mybtn" href="' . route('admin.category_form_field_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['category'] = $val->name ?? '';
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

    public function add_category_form_field(){
        $category = Category::where('name','!=','All')->where('status','1')->orderBy('rank', 'asc')->get();
        $selectoption = CategoryFieldOption::where('status','1')->get();
        return view('admin.add_category_form_field',compact('selectoption','category'));
    }

    public function insert_category_form_field(Request $request){

        $categoryexistsformfielddata = CategoryField::where('category_id', $request->category_id)->first();
        if($categoryexistsformfielddata){
             return response()->json([
                'status' => 'error',
                'message' => 'Already added this category data',
            ]);
        }

        if (empty($request->label)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Select at list one data',
            ]);
        }

        $staticFields = staticformfield();

        foreach ($staticFields as $field) {
            $CategoryField = new CategoryField;
            $CategoryField->category_id = $request->category_id;
            $CategoryField->label = $field['label'];
            $CategoryField->name = $field['name'];
            $CategoryField->type = $field['type'];
            $CategoryField->options = $field['options'];
            $CategoryField->options_selection = $field['options_selection'];
            $CategoryField->is_required = $field['is_required'];
            $CategoryField->sort_order = $field['sort_order']; 
            $CategoryField->status = '1';
            $CategoryField->save();
        }



        foreach ($request->label as $index => $label) {
                $name  = $request->name[$index];
                $exists = CategoryField::where('category_id', $request->category_id)
                    ->where('label', $label)
                    ->where('name', $name)
                    ->exists();

                if ($exists) {
                    continue;
                }

                $max = CategoryField::where('category_id', $request->category_id)->max('sort_order');

                $options = null;
                if(!empty($request->options[$index])){
                        $options = !empty($request->options[$index]) ? json_encode($request->options[$index]) : null;
                }
                
                $CategoryField = new CategoryField;
                $CategoryField->category_id = $request->category_id;
                $CategoryField->label = $label;
                $CategoryField->name = $name;
                $CategoryField->type = $request->type[$index];
                $CategoryField->options = $options;
                $CategoryField->options_selection = $request->options_selection[$index] ?? null;
                $CategoryField->is_required = $request->is_required[$index];
                $CategoryField->sort_order = ($max ?? 0) + 1;
                $CategoryField->status = '1';
                $CategoryField->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.category_form_field'),
        ]);
    }

    public function category_form_field_edit($id){
        $category = Category::where('name','!=','All')->where('status','1')->orderBy('rank', 'asc')->get();
        $selectoption = CategoryFieldOption::where('status','1')->get();
        $editcategoryformfield = CategoryField::where('category_id',$id)->get();
        return view('admin.edit_category_form_field',compact('selectoption','category','editcategoryformfield'));
    }

    public function category_form_field_status_change(Request $request){
        $userdata = CategoryField::find($request->id);

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

    public function update_category_form_field(Request $request){

        
        if (empty($request->label)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Select at list one data',
            ]);
        }


        foreach ($request->label as $index => $label) {
                $name  = $request->name[$index];
                $exists = CategoryField::where('category_id', $request->category_id)
                    ->where('label', $label)
                    ->where('name', $name)
                    ->exists();

                if ($exists) {
                    continue;
                }

                $max = CategoryField::where('category_id', $request->category_id)->max('sort_order');

                $options = null;
                if(!empty($request->options[$index])){
                        $options = !empty($request->options[$index]) ? json_encode($request->options[$index]) : null;
                }
                
                $CategoryField = new CategoryField;
                $CategoryField->category_id = $request->category_id;
                $CategoryField->label = $label;
                $CategoryField->name = $name;
                $CategoryField->type = $request->type[$index];
                $CategoryField->options = $options;
                $CategoryField->options_selection = $request->options_selection[$index] ?? null;
                $CategoryField->is_required = $request->is_required[$index];
                $CategoryField->sort_order = ($max ?? 0) + 1;
                $CategoryField->status = '1';
                $CategoryField->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.category_form_field'),
        ]);
    }




}
