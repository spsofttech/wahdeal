<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        return view('admin.plan');
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
        $columns = ['id','title', 'month','old_amount','latest_amount','discount_text'];

        $query = Plan::select('*');

        if ($search) {
                $query->where(function ($q) use ($search) {
                     $q->where('title', 'like', "%{$search}%")
                    ->orWhere('discount_text', 'like', "%{$search}%");
                });
        }
       
        $query = $query->orderBy($columns[$orderColumn], $orderDir);


        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = Plan::count();
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
               <a class="btn btn-link mybtn" href="' . route('admin.plan_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
            <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['title'] = $val->title;
            $sub_array['month'] = $val->month;
            $sub_array['old_amount'] = $val->old_amount;
            $sub_array['latest_amount'] = $val->latest_amount;
            $sub_array['discount_text'] = $val->discount_text;
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

    public function add_plan(){
        return view('admin.add_plan');
    }

    public function insert_plan(Request $request){

        $plandata = Plan::where('title',$request->title)->first();
        if($plandata){
             return response()->json([
                'status' => 'error',
                'message' => 'Plan already added',
            ]);
        }


        $plan = new Plan;
        $plan->title = $request->title;
        $plan->month = $request->month;
        $plan->old_amount = $request->old_amount;
        $plan->latest_amount = $request->latest_amount;
        $plan->discount_text = $request->discount_text;
        $plan->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.plan'),
        ]);
    }

    public function plan_edit($id){
        $plan = Plan::where('id',$id)->first();
        return view('admin.edit_plan',compact('plan'));
    }

    public function update_plan(Request $request){

        $plandata = Plan::where('title',$request->title)->where('id','!=',$request->id)->first();
        if($plandata){
             return response()->json([
                'status' => 'error',
                'message' => 'Plan already added',
            ]);
        }

        $plan = Plan::find($request->id);
        $plan->title = $request->title;
        $plan->month = $request->month;
        $plan->old_amount = $request->old_amount;
        $plan->latest_amount = $request->latest_amount;
        $plan->discount_text = $request->discount_text;
        $plan->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.plan'),
        ]);
    }

    public function plan_status_change(Request $request){
        $userdata = Plan::find($request->id);

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

    public function plan_delete(Request $request){
        $userdata = Plan::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }

    
}
