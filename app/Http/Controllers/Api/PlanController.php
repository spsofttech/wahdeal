<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\CouponCode;

class PlanController extends Controller
{
    public function index(Request $request)
    {

        $user = Auth::guard('api')->user();
        if ($user) {
            $uid = $user->id;
        }else{
            $uid = 0;
        }


        $today = Carbon::today()->toDateString();
        $plan = Plan::where('status','1')->get();


        $couponcode = $request->coupon_code;
        $plan_id = $request->plan_id;
        $coupon_code_discount_val = 0;
        $plan_amt = 0;


        if($plan_id != ''){
            $lastplan = Plan::where('id', $plan_id)->first();
        }else{
            $lastplan = Plan::where('status', '1')->orderByDesc('id')->first();
        }


        if($lastplan){
            $plan_amt = $lastplan->latest_amount;
            if($couponcode != ''){
                $coupon_code_data = CouponCode::where('code',$couponcode)
                ->whereDate('end_date', '>=', $today)
                ->where('type','3')
                ->where('status','1')
                ->first();

                if(!$coupon_code_data){
                    return sendError(array(), 'Coupon code not valid'); 
                }

                if($coupon_code_data->discount_type == 'fixed'){
                    $coupon_code_discount_val = $lastplan->latest_amount - $coupon_code_data->discount_value;
                }else{
                    $coupon_code_discount_val = ($lastplan->latest_amount*$coupon_code_data->discount_value)/100;
                }
            }

        }



        $charge_val = [
            'Plan Amount' => $plan_amt,
            'Discount' =>$coupon_code_discount_val,
        ];

        $charge = collect($charge_val)->map(function ($value, $key) {
            if($key == 'Plan Amount'){
                $cdtype = 'Credit';
            }else if($key == 'Discount'){
                $cdtype = 'Debit';
            }else{
                $cdtype = '';
            }

            return [
                'name' => $key,
                'value' => (string) $value,
                'type' => $cdtype
            ];
        })->values()->toArray();


       

        $all_coupon_code = CouponCode::whereDate('end_date', '>=', $today)
        ->where('status','1')
        ->where('type','3')
        ->get();
        $all_coupon_data_array = array();
        foreach ($all_coupon_code as $val) {
            $alreadycouponuser =  usedcoupon($val->id,$uid);
            $uselimit = $val->usage_limit;

            if($uselimit <= $alreadycouponuser){
                continue;
            }
            $all_coupon_data_array[] = $val;
        }



        $data['plan'] = $plan;
        $data['all_coupon'] = $all_coupon_data_array;
        $data['charge'] = $charge;
        return sendResponse($data, 'Data fetched successfully.');
    }
}
