<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class SubCategoryController extends Controller
{
    public function index()
    {
        return view('admin.subcategory');
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

        $query = SubCategory::join('categories', 'categories.id', '=', 'subcategories.category_id')
        ->where('subcategories.name','!=', 'All')
        ->select('subcategories.*','categories.name as category_name');

        if ($search) {
                $query->where(function ($q) use ($search) {
                     $q->where('subcategories.name', 'like', "%{$search}%")
                    ->orWhere('categories.name', 'like', "%{$search}%");
                });
        }
       
        $query = $query->orderBy('categories.rank', 'asc')->orderBy('subcategories.rank', 'asc');

        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = SubCategory::join('categories', 'categories.id', '=', 'subcategories.category_id')
        ->where('subcategories.name','!=', 'All')
        ->where('categories.is_fashion','=', '0')->count();
        $filteredRecords = count($filtertotalget);

       
        $i =  $request->get('start');
        $data = array();
        foreach($users as $val){
           $i++;

           $imagepath = $val->icon 
           ? asset('uploads/subcategory/' . $val->icon) 
           : asset('images/logo.png');


            $uimage = '<img class="status-img" src="' . $imagepath .'" alt="'.$val->icon.'" style="width:40px;">';

           $checked = '';
           if($val->status == 1){
               $checked = 'checked';
           }

            $status = '<label class="switch"><input type="checkbox" '.$checked.' onchange="changestatus('.$val->id.')"><span class="slider"></span></label>';
        
            $action = '
               <a class="btn btn-link mybtn" href="' . route('admin.sub_category_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
            <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['id'] = $val->id;
            $sub_array['category_id'] = $val->category_id;
            $sub_array['category'] = $val->category_name;
            $sub_array['name'] = $val->name;
            $sub_array['icon'] = $uimage;
            $sub_array['gst'] = $val->gst;
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

    public function sub_category_reorder(Request $request)
    {
        $order = $request->input('order');

        if ($order && is_array($order)) {
            foreach ($order as $item) {
                $subcategory = SubCategory::where('id', $item['id'])
                    ->where('category_id', $item['category_id'])
                    ->first();

                if ($subcategory) {
                    $subcategory->update(['rank' => $item['rank']]);
                }
            }

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }


    public function add_subcategory(){
        $category = Category::where('name','!=','All')->where('status','1')->orderBy('rank', 'asc')->get();
        return view('admin.add_subcategory',compact('category'));
    }

    public function insert_sub_category(Request $request){

        $fileName = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/subcategory'), $fileName);
        }


        $newCategory = new SubCategory;
        $newCategory->category_id = $request->category_id;
        $newCategory->name = $request->name;
        $newCategory->gst = $request->gst;
        $newCategory->icon = $fileName;
        $newCategory->rank = SubCategory::max('rank') + 1;
        $newCategory->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.sub_category'),
        ]);
    }

    public function sub_category_edit($id){
        $category = Category::where('name','!=','All')->where('status','1')->orderBy('rank', 'asc')->get();
        $subcategory = SubCategory::where('id',$id)->first();
        return view('admin.edit_sub_category',compact('subcategory','category'));
    }

    public function update_sub_category(Request $request){

        $user = SubCategory::find($request->id);

        $fileName = '';
        if ($request->hasFile('image')) {
            $filePath = public_path('uploads/subcategory/'.$user->icon);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }


            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/subcategory'), $fileName);
            $user->icon = $fileName;
        }
        $user->category_id = $request->category_id;
        $user->name = $request->name;
        $user->gst = $request->gst;
        $user->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.sub_category'),
        ]);
    }

    public function sub_category_status_change(Request $request){
        $userdata = SubCategory::find($request->id);

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

    public function sub_category_delete(Request $request){
        $userdata = SubCategory::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }
}
