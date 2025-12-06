<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserDeal;
use App\Models\UserLike;
use App\Models\UserBookAppointment;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index() 
    {
        return view('admin.user');
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
        $columns = ['id','image','first_name','last_name','mobile','email','gender','state','city','wallet_balance','created_at'];

         $query = User::select('*');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('mobile', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('gender', 'like', "%{$search}%")
                ->orWhere('state', 'like', "%{$search}%")
                ->orWhere('city', 'like', "%{$search}%")
                ->orWhere('wallet_balance', 'like', "%{$search}%");
            });
        }
       
        $query = $query->orderBy($columns[$orderColumn], $orderDir);


        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = User::count();
        $filteredRecords = count($filtertotalget);

       
        $i =  $request->get('start');
        $data = array();
        foreach($users as $val){
           $i++;

           $imagepath = $val->image 
           ? asset('uploads/user/' . $val->image) 
           : asset('images/logo.png');
           $uimage = '<img class="status-img" src="' . $imagepath .'" alt="'.$val->icon.'" style="width:40px;">';


           $checked = '';
           if($val->status == 1){
               $checked = 'checked';
           }

           
            $status = '<label class="switch"><input type="checkbox" '.$checked.' onchange="changestatus('.$val->id.')"><span class="slider"></span></label>';

            $action = '
                <a class="btn btn-link mybtn" href="' . route('admin.user_view', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-eye" style="color:#007bff!important;" title="View"></i>
                        </a>

               <a class="btn btn-link mybtn" href="' . route('admin.user_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
            <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['image'] = $uimage;
            $sub_array['first_name'] = $val->first_name;
            $sub_array['last_name'] = $val->last_name;
            $sub_array['mobile'] = $val->mobile;
            $sub_array['email'] = $val->email;
            $sub_array['gender'] = $val->gender;
            $sub_array['state'] = $val->state;
            $sub_array['city'] = $val->city;    
            $sub_array['wallet_balance'] = $val->wallet_balance;     
            $sub_array['created_at'] = Carbon::parse($val->created_at)->format('d, M Y');        
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

    public function user_view($id){
        $user = User::where('id',$id)->first();
        $ref_user = User::where('id',$user->ref_user_id)->select('first_name','last_name')->first();
        $user_address = UserAddress::where('user_id',$id)->orderBy('id', 'DESC')->limit(3)->get();

        $deal = UserDeal::with(['offer', 'branch','product'])
            ->where('user_id', $user->id)
            ->orderByDesc('id') 
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->get();
        
            $ulike = UserLike::leftJoin('products', 'user_likes.product_id', '=', 'products.id')
            ->leftJoin('brands', 'user_likes.brand_id', '=', 'brands.id')
            ->where('user_likes.user_id',$user->id)
            ->where('user_likes.status','1')
            ->select('brands.name as brand_name','products.name as product_name')
            ->orderBy('user_likes.id', 'desc')
            ->get();

            $b_like = '';
            $p_like = '';
            if($ulike){
                $b_like = $ulike->pluck('brand_name')->filter()->unique()->implode(', ');
                $p_like = $ulike->pluck('product_name')->filter()->unique()->implode(', ');
            }

            

        $booking = UserBookAppointment::where('user_id',$user->id)->orderBy('id', 'desc')->limit('3')->get();
        return view('admin.view_user',compact('user','ref_user','user_address','deal','b_like','p_like','booking'));
    }

    public function user_edit($id){
        $user = User::where('id',$id)->first();
        return view('admin.edit_user',compact('user'));
    }

    public function update_user(Request $request){

        $user = User::find($request->id);

        $user->first_name  = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->gender = $request->gender;

        if($request->password){
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/user'), $fileName);
            $user->image = $fileName;
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.user'),
        ]);
    }

    public function user_status_change(Request $request){
        $userdata = User::find($request->id);

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

    public function user_delete(Request $request){
        $userdata = User::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }

}
