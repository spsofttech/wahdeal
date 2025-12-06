<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Brand;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('brand')->user();
        return view('brand.order');
    }

    public function get_list(Request $request)
    {
        $admin = Auth::guard('brand')->user();
        if ($request->ajax()) 
        {
            $start = $request->get('start', 0);
            $length = $request->get('length', 10); 
            $orderColumn = $request->input('order_column');
            $orderDir = $request->input('order_dir', 'asc');
            $search = $request->get('search')['value'];
            $columns = ['order_details.id'];

            $query = OrderDetail::
            join('orders', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('offers', 'offers.id', '=', 'order_details.offer_id')
            ->leftJoin('sizes', 'sizes.id', '=', 'order_details.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'order_details.color_id')
            ->where('order_details.branch_id',$admin->id)
            ->select('order_details.*','orders.order_number','products.name as product_name','offers.title as offer_title','sizes.name as size_name','colors.name as color_name');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('orders.order_number', 'like', "%{$search}%")
                     ->orWhere('products.name', 'like', "%{$search}%")
                     ->orWhere('offers.title', 'like', "%{$search}%")
                     ->orWhere('order_details.price', 'like', "%{$search}%")
                      ->orWhere('order_details.final_price', 'like', "%{$search}%");
                });
            }
        
            $query = $query->orderBy($columns[$orderColumn], $orderDir);


            $filtertotalget =  $query->get();
            $users = $query->skip($start)->take($length)->get();


            $totalRecords = OrderDetail::
            join('orders', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->where('order_details.branch_id',$admin->id)->count();
            $filteredRecords = count($filtertotalget);

        
            $i =  $request->get('start');
            $data = array();
            foreach($users as $val){
                $i++;

                $jsondata = json_decode($val->product, true);

                $action = '
                        <a class="btn btn-link mybtn" href="' . route('brand.order_view', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-eye" style="color:#007bff!important;" title="View"></i>
                        </a>';
                
                $sub_array = [];
                $sub_array['no'] = $i;
                $sub_array['order_no'] = $val->order_number ?? '';
                $sub_array['product'] = $val->product_name ?? '';
                $sub_array['offer'] = $val->offer_title ?? '';
                $sub_array['size'] = $val->size_name ?? '';
                $sub_array['color'] = $val->color_name ?? '';
                $sub_array['quantity'] = $val->quantity ?? '';
                $sub_array['price'] = $val->price ?? '';
                $sub_array['final_price'] = $val->final_price ?? '';
                $sub_array['status'] = $val->cart_status_text ?? '';
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

     public function order_view($id){
        $order = OrderDetail::
            join('orders', 'orders.id', '=', 'order_details.order_id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('offers', 'offers.id', '=', 'order_details.offer_id')
            ->leftJoin('sizes', 'sizes.id', '=', 'order_details.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'order_details.color_id')
            ->where('order_details.id',$id)
            ->select('order_details.*','users.first_name','users.last_name','users.mobile','users.email','orders.order_number','products.id as product_id','offers.title as offer_title','sizes.name as size_name','colors.name as color_name')
            ->first();

        $product = Product::where('id',$order->product_id)->first();
        $brand = Brand::where('id',$product->brand_id)->first();    
       

        return view('brand.order_view',compact('id','order','product','brand'));
    }

    public function order_change_status(Request $request){
        $id = $request->id;

        $order = OrderDetail::where('id',$id)->first();
        $order->order_status = $request->status;
        $order->save();


        $details = OrderDetail::where('order_id', $order->order_id)->pluck('order_status');
        $statuses = $details;
        $orderdata = Order::where('id', $order->order_id)->first();

        if($orderdata->order_status != '4' || $orderdata->order_status != '7'){
            if ($statuses->every(fn($s) => in_array($s, [4, 5])) && $statuses->contains(4)) {
                $status = 4;
            }
            elseif ($statuses->every(fn($s) => in_array($s, [7, 5])) && $statuses->contains(7)) {
                $status = 7;
            }
            elseif ($statuses->every(fn($s) => $s == 4)) {
                $status = 4;
            }
            elseif ($statuses->every(fn($s) => $s == 7)) {
                $status = 7;
            }
            elseif ($statuses->every(fn($s) => $s == 5)) {
                $status = 5;
            }
            else {
                $status = 1;
            }

            Order::where('id', $order->order_id)->update([
                'order_status' => $status
            ]);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully!'
        ]);
    }
}
