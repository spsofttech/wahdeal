<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CouponCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class CouponController extends Controller
{
    public function index() 
    {
        return view('admin.coupon');
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
        $columns = ['id','code','title','discount_type','discount_value','end_date','type'];

         $query = CouponCode::select('*');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%")
                ->orWhere('discount_type', 'like', "%{$search}%")
                ->orWhere('discount_value', 'like', "%{$search}%")
                ->orWhere('end_date', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%");
            });
        }
       
        $query = $query->orderBy($columns[$orderColumn], $orderDir);


        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = CouponCode::count();
        $filteredRecords = count($filtertotalget);

       
        $i =  $request->get('start');
        $data = array();
        foreach($users as $val){
           $i++;

           $checked = '';
           if($val->status == 1){
               $checked = 'checked';
           }

           if($val->type == '1'){
            $type = 'Offline';
           }else if($val->type == '2'){
             $type = 'Online';
           }else if($val->type == '3'){
             $type = 'Subscription';
           }else{
             $type = 'Booking';
           }

           
            $status = '<label class="switch"><input type="checkbox" '.$checked.' onchange="changestatus('.$val->id.')"><span class="slider"></span></label>';

            $action = '
               <a class="btn btn-link mybtn" href="' . route('admin.coupon_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
            <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['code'] = $val->code;
            $sub_array['title'] = $val->title;
            $sub_array['discount_type'] = $val->discount_type;
            $sub_array['discount_value'] = $val->discount_value;
            $sub_array['end_date'] = Carbon::parse($val->end_date)->format('d, M Y');
            $sub_array['type'] = $type;
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

    public function add_coupon(){
        return view('admin.add_coupon');
    }

    public function insert_coupon(Request $request){


        $ce = CouponCode::where('code',$request->code)->first();
        if($ce){
            return response()->json([
                'status' => 'error',
                'message' => 'Code already exists',
            ]);
        }


        $fileName = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/coupon'), $fileName);
        }

    
        $newCategory = new CouponCode;
        $newCategory->code  = $request->code;
        $newCategory->title  = $request->title;
        $newCategory->discount_type  = $request->discount_type;
        $newCategory->discount_value  = $request->discount_value;
        $newCategory->end_date  = $request->end_date;
        $newCategory->usage_limit  = $request->usage_limit;
        $newCategory->type  = $request->type;
        $newCategory->image = $fileName;
        $newCategory->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.coupon'),
        ]);
    }

    public function coupon_edit($id){
        $coupon = CouponCode::where('id',$id)->first();
        return view('admin.edit_coupon',compact('coupon'));
    }

    public function update_coupon(Request $request){

        $newCategory = CouponCode::where('id',$request->id)->first();

        $ce = CouponCode::where('code',$request->code)->where('id','!=',$request->id)->first();

        if($ce){
            return response()->json([
                'status' => 'error',
                'message' => 'Code already exists',
            ]);
        }


        if ($request->hasFile('image')) {
            $filePath = public_path('uploads/coupon/'.$newCategory->image);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }


            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/coupon'), $fileName);
            $newCategory->image = $fileName;
        }

        
        $newCategory->code  = $request->code;
        $newCategory->title  = $request->title;
        $newCategory->discount_type  = $request->discount_type;
        $newCategory->discount_value  = $request->discount_value;
        $newCategory->end_date  = $request->end_date;
        $newCategory->usage_limit  = $request->usage_limit;
        $newCategory->type  = $request->type;
        $newCategory->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.coupon'),
        ]);
    }



    public function coupon_status_change(Request $request){
        $userdata = CouponCode::find($request->id);

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

    public function coupon_delete(Request $request){
        $userdata = CouponCode::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }
}
