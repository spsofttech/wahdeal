<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\CouponCode;
use App\Models\Cart;
use App\Models\UserCouponCode;
use App\Models\UserAddress;
use App\Models\ProductIssueCategory;
use App\Models\ProductIssueReason;

class OrderController extends Controller
{
    public function create_order(Request $request)
    {
        $rules = [
            'user_address_id' => 'required',
            'payment_method' => 'required',
            'payment_status' => 'required',
            'total' => 'required',
            'charge' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();
        if (!$user) {
            return sendError(array(), 'User not exists'); 
        }

        if($request->coupon_code_id){
            $coupon_code_data = CouponCode::where('id',$request->coupon_code_id)->first();
            if (!$coupon_code_data) {
                return sendError(array(), 'Coupon code not valid'); 
            }
        }

        if($request->payment_method == '1'){
            $payment_status = 'pending';
        }else{
            $payment_status = 'paid';
        }
        

        $orderno = get_order_no();
        
        $order = new Order;
        $order->user_id = $user->id;
        $order->user_address_id = $request->user_address_id;

        if($request->coupon_code_id){
            $order->coupon_code_id = $request->coupon_code_id;
        }

        if($request->transaction_id){
            $order->transaction_id = $request->transaction_id;
        }

        if($request->transaction_response){
            $order->transaction_response = $request->transaction_response;
        }

        $order->order_number = $orderno;
        $order->total = $request->total;
        $order->charge = $request->charge;
        $order->payment_method = $request->payment_method;
        $order->payment_status = $payment_status;
        $order->order_status = '1';
        $order->save();


        $cart = Cart::where('user_id',$user->id)->get();

        foreach($cart as $val){
            $order_detail = new OrderDetail;
            $order_detail->order_id = $order->id;
            $order_detail->product_id = $val->product_id;
            $order_detail->branch_id = $val->branch_id;
            $order_detail->offer_id = $val->offer_id;
            $order_detail->size_id = $val->size_id;
            $order_detail->color_id = $val->color_id;
            $order_detail->quantity = $val->quantity;
            $order_detail->price = $val->price;
            $order_detail->gst = $val->gst;
            $order_detail->gst_price = $val->gst_price;
            $order_detail->discount = $val->discount;
            $order_detail->final_price = $val->final_price;
            $order_detail->order_status = '1';
            $order_detail->save();
        }

        Cart::where('user_id',$user->id)->delete();


        if($request->coupon_code_id){
            $uc = new UserCouponCode;   
            $uc->user_id = $user->id;
            $uc->coupon_code_id = $request->coupon_code_id;
            $uc->save();
        }

        return sendResponse($order, 'Order created successfully.');
        
    }

    public function order_history(Request $request)
    {
        $rules = [
            'page' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();
        if (!$user) {
            return sendError([], 'User not exists');
        }

        $page = $request->page;
        $limit = env('PAGINATION_LIMIT', 10);
        $offset = ($page - 1) * $limit;   // ← FIXED

        // MAIN QUERY
        $orders = Order::where('user_id', $user->id);

        // FILTER : Status
        if ($request->order_status) {
            $orders->where('order_status', $request->order_status);
        }

        // FILTER : DATE RANGE
        if ($request->start_date && $request->end_date) {

            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate   = Carbon::parse($request->end_date)->endOfDay();

            $orders->whereBetween('created_at', [$startDate, $endDate]);
        }

        $total_count = (clone $orders)->count();

        
        $paginationdata = $orders
            ->orderBy('id', 'DESC')
            ->skip($offset)
            ->take($limit)
            ->get();

        $Order_Data = [];
        foreach ($paginationdata as $val) {

            $products = OrderDetail::join('products', 'products.id', '=', 'order_details.product_id')
                ->where('order_details.order_id', $val['id'])
                ->pluck('products.name')
                ->implode(', ');

            if($val['order_status'] > 3){
                $delivery_date = '';
            }else{
                $delivery_date = $val['created_at']->addDay();
            }   
            
            if($val['order_status'] == '1'){
                $full_order_is_cancelled = '1';
            }else{
                    $full_order_is_cancelled = '0';
            }
            

            $Order_Data[] = [
                'id'  => $val['id'],
                'order_number' => $val['order_number'],
                'status' => $val['order_status'],
                'order_status_text' => $val['order_status_text'],
                'total' => $val['total'],
                'created_at' => Carbon::parse($val['created_at'])->addDay()->toDateTimeString(),
                'product_count' => $val->details->count(),
                'product' => $products,
                'order_delivered_date'    => $delivery_date,
                'is_cancelled'     => $full_order_is_cancelled,
                'order_cancel_reason'    => $val['cancel_note'],
            ];
        }

        // NEXT PAGE LOGIC
        $total_page = ceil($total_count / $limit);
        $is_nextpage = ($total_page > $page) ? '1' : '0';



        $order_status_types = Order::statusList();

        $data['order'] = $Order_Data;
        $data['status_type'] = $order_status_types;

        return sendResponsePagination($data, 'Order History Fetched Successfully.', $is_nextpage);
    }


    public function order_detail(Request $request){
        $rules = [
            'id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = auth()->id();

        $user = Auth::guard('api')->user();
        if (!$user) {
            return sendError(array(), 'User not exists'); 
        }


        $orderdetail = order_detail($request->id,$user);

        

        return sendResponse($orderdetail, 'Data fetched successfully.');
    }

    public function change_order_delivery_address(Request $request){
        $rules = [
            'order_id' => 'required',
            'address_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = auth()->id();

        $user = Auth::guard('api')->user();
        if (!$user) {
            return sendError(array(), 'User not exists'); 
        }

        $order = Order::where('id',$request->order_id)->first();

        if (!$order) {
            return sendError(array(), 'Order not exists'); 
        }


        $useraddress = UserAddress::where('user_id',$user->id)->where('id',$request->address_id)->first();

        if (!$useraddress) {
            return sendError(array(), 'Address not exists'); 
        }

        $order->user_address_id = $request->address_id;
        $order->save();

        $orderdetail = order_detail($request->order_id,$user);

        return sendResponse($orderdetail, 'Address change successfully.');
    }


    public function cancel_order_item(Request $request){
        $rules = [
            'order_id' => 'required',
            'item_id' => 'required',
            'reason' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        
        $couponcode = '';
        $user = Auth::guard('api')->user();
        if (!$user) {
            return sendError(array(), 'User not exists'); 
        }

        $order = Order::where('id',$request->order_id)->first();

        if (!$order) {
            return sendError(array(), 'Order not exists'); 
        }


        $item = OrderDetail::where('id',$request->item_id)->first();

        if (!$item) {
            return sendError(array(), 'Item not exists'); 
        }

        $item->order_status = '5';
        $item->cancel_reason = $request->reason;
        $item->save();



    

        /* order update */
            $coupon_code_data = CouponCode::where('id',$order->coupon_code_id)->first();
            if($coupon_code_data){
                $couponcode = $coupon_code_data->code;
            }
            $cart = cancel_cart($request->order_id,$request->item_id,$couponcode,$user);
            $credit = 0;
            $debit = 0;
            foreach ($cart['charge'] as $item) {

                if (strtolower($item['type']) == 'credit') {
                    $credit += $item['value'];
                }

                if (strtolower($item['type']) == 'debit') {
                    $debit += $item['value'];
                }
            }
            $final_amount = $credit - $debit;
            $charge = json_encode($cart['charge']);

            $order->total = $final_amount;
            $order->charge = $charge;
            $order->save();
         /* order update */

        


        $data = OrderDetail::with([
                    'product',
                    'size',
                    'color'
                ])->find($request->item_id);

                
        $product =  [
                    'id'         => $data->id,
                    'product_id' => $data->product_id,
                    'name'       => $data->product->name ?? '',
                    'image'      => asset('uploads/product/' . $data->product->image) ?? '',
                    'size'       => $data->size->name ?? '',
                    'color'      => $data->color->name ?? '',
                    'quantity'   => $data->quantity,
                    'status'     => $data->cart_status_text,
                ];


        return sendResponse($product, 'Order item cancelled successfully.');
    }


    public function cancel_order(Request $request){
        $rules = [
            'order_id' => 'required',
            'reason_id' => 'required',
            'note' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();
        if (!$user) {
            return sendError(array(), 'User not exists'); 
        }

        $order = Order::where('id',$request->order_id)->where('user_id',$user->id)->first();
        if (!$order) {
            return sendError(array(), 'Order not exists'); 
        }

        $reason = ProductIssueReason::where('id',$request->reason_id)->first();
        if (!$reason) {
            return sendError(array(), 'Reason not exists'); 
        }



        if($order->order_status == '5'){
            return sendError(array(), 'Order already cancelled'); 
        }



        $order->order_status = '5';
        $order->cancel_reason_id = $request->reason_id;
        $order->cancel_note = $request->note;
        $order->save();


        $upd = [
            'order_status' => '5', 
            'cancel_reason' => $request->note,
            'updated_at' => now()
        ];

        OrderDetail::where('order_id', $request->order_id)
           ->where('order_status', '!=', '5')
           ->update($upd);

        return sendResponse($order, 'Order cancelled successfully.');
    }
}
