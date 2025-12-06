<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductIssueCategory;
use App\Models\ProductIssueReason;

class ProductIssueReasonController extends Controller
{
    public function index()
    {
        return view('admin.product_issue_reason');
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
        $columns = ['product_issue_reasons.id','product_issue_categories.title','product_issue_reasons.title'];

        $query = ProductIssueReason::
        leftJoin('product_issue_categories', 'product_issue_categories.id', '=', 'product_issue_reasons.product_issue_category_id')
        ->select('product_issue_reasons.*','product_issue_categories.title as category');

        if ($search) {
                $query->where(function ($q) use ($search) {
                     $q->where('product_issue_categories.title', 'like', "%{$search}%")
                     ->orWhere('product_issue_reasons.title', 'like', "%{$search}%");
                });
        }
       
        $query = $query->orderBy($columns[$orderColumn], $orderDir);


        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = ProductIssueReason::count();
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
               <a class="btn btn-link mybtn" href="' . route('admin.product_issue_reason_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
            <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['category'] = $val->category;
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

    public function add_product_issue_reason(){
        $category = ProductIssueCategory::where('status','1')->get();
        return view('admin.add_product_issue_reason',compact('category'));
    }

    public function insert_product_issue_reason(Request $request){

        $reasondata = ProductIssueReason::where('title',$request->title)->where('product_issue_category_id',$request->product_issue_category_id)->first();
        if($reasondata){
             return response()->json([
                'status' => 'error',
                'message' => 'Reason already added',
            ]);
        }



        $reason = new ProductIssueReason;
        $reason->product_issue_category_id = $request->product_issue_category_id;
        $reason->title = $request->title;
        $reason->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.product_issue_reason'),
        ]);
    }

    public function product_issue_reason_edit($id){
        $category = ProductIssueCategory::where('status','1')->get();
        $reason = ProductIssueReason::where('id',$id)->first();
        return view('admin.edit_product_issue_reason',compact('category','reason'));
    }

    public function update_product_issue_reason(Request $request){

        $reasondata = ProductIssueReason::where('id','!=',$request->id)->where('title',$request->title)->where('product_issue_category_id',$request->product_issue_category_id)->first();
        if($reasondata){
             return response()->json([
                'status' => 'error',
                'message' => 'Reason already added',
            ]);
        }

        $reason = ProductIssueReason::where('id',$request->id)->first();
        $reason->product_issue_category_id = $request->product_issue_category_id;
        $reason->title = $request->title;
        $reason->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.product_issue_reason'),
        ]);
    }

    public function product_issue_reason_status_change(Request $request){
        $userdata = ProductIssueReason::find($request->id);

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

    public function product_issue_reason_delete(Request $request){
        $userdata = ProductIssueReason::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }
}
