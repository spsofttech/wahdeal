<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductIssueCategory;

class ProductIssueCategoryController extends Controller
{
    public function index()
    {
        return view('admin.product_issue_category');
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
        $columns = ['id','title'];

        $query = ProductIssueCategory::select('*');

        if ($search) {
                $query->where(function ($q) use ($search) {
                     $q->where('title', 'like', "%{$search}%");
                });
        }
       
        $query = $query->orderBy($columns[$orderColumn], $orderDir);


        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = ProductIssueCategory::count();
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
               <a class="btn btn-link mybtn" href="' . route('admin.product_issue_category_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
            <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['title'] = $val->title;
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

    public function add_product_issue_category(){
        return view('admin.add_product_issue_category');
    }

    public function insert_product_issue_category(Request $request){

        $catedata = ProductIssueCategory::where('title',$request->title)->first();
        if($catedata){
             return response()->json([
                'status' => 'error',
                'message' => 'Category already added',
            ]);
        }



        $ProductIssueCategory = new ProductIssueCategory;
        $ProductIssueCategory->title = $request->title;
        $ProductIssueCategory->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.product_issue_category'),
        ]);
    }

    public function product_issue_category_edit($id){
        $category = ProductIssueCategory::where('id',$id)->first();
        return view('admin.edit_product_issue_category',compact('category'));
    }

     public function update_product_issue_category(Request $request){


        $catedata = ProductIssueCategory::where('title',$request->title)->where('id','!=',$request->id)->first();
        if($catedata){
             return response()->json([
                'status' => 'error',
                'message' => 'Category already added',
            ]);
        }


        $ProductIssueCategory = ProductIssueCategory::find($request->id);
        $ProductIssueCategory->title = $request->title;
        $ProductIssueCategory->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.product_issue_category'),
        ]);
    }

    public function product_issue_category_status_change(Request $request){
        $userdata = ProductIssueCategory::find($request->id);

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

    public function product_issue_category_delete(Request $request){
        $userdata = ProductIssueCategory::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }
}
