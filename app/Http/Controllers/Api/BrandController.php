<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\BrandTiming;
use App\Models\ProductRating;
use App\Models\BrandView;
use App\Models\BrandMenu;
use App\Models\ProductView;
use App\Models\Category;
use App\Models\ShortLink;
use App\Models\CategoryField;
use App\Models\Branch;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $rules = [
            'id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();
        $id = $request->id;
        $search_discount =  $request->discount;

        if($user){
            $uid = $user->id;
        }else{
            $uid = '0';
        }

        if($request->latitude){
            $user_lat    = $request->latitude;
            $user_long   = $request->longitude;
        }else{
            $userlatitude = getstaticlatlong();
            $user_lat = $userlatitude['lat'];
            $user_long = $userlatitude['long'];
        }

        $brand = Brand::where('id',$id)->first();

        if(!$brand){
            return sendError(array(), 'Brand not exists'); 
        }

        if($request->branch_id){
            $newbranchdata = Branch::where('id',$request->branch_id)->first();
            $user_lat = $newbranchdata->latitude;
            $user_long = $newbranchdata->longitude;
        }

        $b_link = ShortLink::where('type','brand')->where('item_id',$brand->id)->first();
        $cat = Category::where('id',$brand->category_id)->select('is_fashion','is_booking','is_appointment')->first();
        
        if($request->branch_id){
            $branch =  Branch::where('id',$request->branch_id)->first();
        }else{
            $branch = getNearestBranch($id, $user_lat, $user_long);
        }

        
        
        $dealproducts = getBrandDealsProductsOnly($id, $user_lat, $user_long, $search_discount);

        $branch_all_data = Branch::where('brand_id',$brand->id)->get();

        if($branch){
            $timing = BrandTiming::where('branch_id',$branch->id)->where('brand_id',$id)->where('status','1')->get();
            $brand->is_booking = $branch->is_booking;
            $brand->is_appointment = $branch->is_appointment;
            $brand->description = $branch->about;
        }else{
            $brand->is_booking = '0';
            $brand->is_appointment = '0';
            $timing = array();
        }

        $filters = array();
        $shopingdata = shoping_category_product($uid, $brand->category_id, $brand->subcategory_id, $id, 1, 1000, $filters, $user_lat, $user_long);



        if (!empty($dealproducts)) {
            foreach ($dealproducts as &$val) {
                $prodLikeStatus = '0';
                if ($user) {
                    $prodLikeStatus = product_like($val['id'], $user->id);
                }
                $val['like_status'] = $prodLikeStatus;
                $val['deal_count'] = deal_count($val['id']);
                $val['count'] = ProductView::totalCount($val['id']);
                $val['veg'] = $val['veg_nonveg'];

                $brand_datas = Brand::where('id',$val['brand_id'])->select('icon')->first();
                $val['brand_image'] = asset('uploads/brand/' . $brand_datas->icon);

                unset($val['veg_nonveg']);
            }
        }

        if(!empty($dealproducts)){
            $categoryIds = $dealproducts->pluck('category_id')->unique();
            $deal_similarProducts = similar_product_with_or_without_offer($id,$categoryIds,'0');
        }

        if(!empty($shopingdata)){
            $shopcatid = collect($shopingdata['data'])->pluck('category_id')->unique();
            $shoping_similarProducts = similar_product_with_or_without_offer($id,$shopcatid,'1');
            
        }
        
       
        if(!empty($deal_similarProducts)){
             foreach ($deal_similarProducts as &$dval) {
                $branddata = Brand::find($dval['brand_id']);
                $offer = $dval['offers'];
                $prodLikeStatus = '0';
                if ($user) {
                    $prodLikeStatus = product_like($dval['id'], $user->id);
                }

                $pro_near_location = getNearestBranch($dval['brand_id'], $user_lat, $user_long);
                if($pro_near_location){
                    $dval['location'] = $pro_near_location;
                }else{
                    $dval['location'] = (object) [];
                }

                $newprice = 0;                    
                if(isset($offer->discount_type)){
                    if($offer->discount_type == 'fixed'){
                                $newprice = $dval['price'] - $offer->discount_value;
                    }else{
                        $discount_val = ($dval['price']*$offer->discount_value)/100;
                        $newprice = $dval['price'] - $discount_val;
                    }
                }

                if($newprice == 0){
                    $old_price = "0";
                    $price = $dval['price'];
                }else{
                    $old_price = $dval['price'];
                    $price = $newprice;
                }

                $dval['old_price'] = $old_price;
                $dval['price'] = $price;
                $dval['like_status'] = $prodLikeStatus;
                $dval['deal_count'] = deal_count($dval['id']);
                $dval['count'] = ProductView::totalCount($dval['id']);
                $dval['veg'] = $dval['veg_nonveg'];
                $dval['rating'] = ProductRating::totalRating($dval['id']);
                $dval['brand_name'] = $branddata ? $branddata->name : '';
                $dval['brand_image'] = $branddata ? asset('uploads/brand/' . $branddata->icon) : '';
                unset($dval['veg_nonveg']);
            }
        }

        if(!empty($shoping_similarProducts)){
             foreach ($shoping_similarProducts as &$sval) {
                $branddata = Brand::find($sval['brand_id']);
                $spoffer = $sval['offers'];
                $prodLikeStatus = '0';
                if ($user) {
                    $prodLikeStatus = product_like($sval['id'], $user->id);
                }

                $pro_near_location = getNearestBranch($sval['brand_id'], $user_lat, $user_long);
                if($pro_near_location){
                    $sval['location'] = $pro_near_location;
                }else{
                    $sval['location'] = (object) [];
                }


                $newprice = 0;                    
                if(isset($spoffer->discount_type)){
                    if($spoffer->discount_type == 'fixed'){
                                $newprice = $sval['price'] - $spoffer->discount_value;
                    }else{
                        $discount_val = ($sval['price']*$spoffer->discount_value)/100;
                        $newprice = $sval['price'] - $discount_val;
                    }
                }

                if($newprice == 0){
                    $old_price = "0";
                    $price = $sval['price'];
                }else{
                    $old_price = $sval['price'];
                    $price = $newprice;
                }

                $sval['old_price'] = $old_price;
                $sval['price'] = $price;
                $sval['like_status'] = $prodLikeStatus;
                $sval['deal_count'] = deal_count($sval['id']);
                $sval['count'] = ProductView::totalCount($sval['id']);
                $sval['veg'] = $sval['veg_nonveg'];
                $sval['rating'] = ProductRating::totalRating($sval['id']);
                $sval['brand_name'] = $branddata ? $branddata->name : '';
                $sval['brand_image'] = $branddata ? asset('uploads/brand/' . $branddata->icon) : '';
                unset($sval['veg_nonveg']);
            }
        }
       
        $brand->share = url("/d/{$b_link->code}/{$brand->id}/brand");
        $brand->is_fashion = $cat->is_fashion;
        $brand->discount_per = getBrandDiscountPercentage($id);
        $brand->deals = $dealproducts ?? array();
        $brand->shopingdata = $shopingdata['data'];
        $brand->deal_similar_product = $deal_similarProducts ?? array();
        $brand->shoping_similar_product = $shoping_similarProducts ?? array();
        $brand->location = $branch ?? (object) [];
        $brand->rating = brand_rating($brand->id);
        $brand->timing = $timing;
        $brand->count = BrandView::totalCount($brand->id);
        $brand->deal_count = brand_deal_count($brand->id);

        $likestatus = '0';
        if ($user) {
            $likestatus = brand_like($brand->id,$user->id);
        }

        $brand->like_status = $likestatus;


        if($branch){
            $brand->menu = branchmenu($branch->id);
            $gallery = branchgallery($branch->id);
        }else{
            $brand->menu = brandmenu($brand->id);
            $gallery = brandgallery($brand->id);
        }
        $brand->gallery = $gallery;


        if($user){
            $exists = BrandView::where('brand_id',$brand->id)->where('user_id',$user->id)->first();
            if(!$exists){
                $brandviewdata = array(
                            "brand_id"=>$brand->id,
                            "user_id"=>$user->id,
                        );

                BrandView::create($brandviewdata);
            }
        }

        $brand->payment_text = 'Cash,Debit Card,E-Wallet';

        if($user){
           $brand->is_blur = is_blur($user->id);
        }else{
            $brand->is_blur = '0';
        }

        $brand->product_review = brand_review($brand->id);

        $bookingform = CategoryField::where('category_id',$brand->category_id)->where('status','1')->orderBy('sort_order', 'asc')->get();

        if(!empty($bookingform)){
            foreach ($bookingform as &$bfval) {
                $bfval['options'] = json_decode($bfval['options'], true);

                if($user){
                    if($bfval['label'] == 'User Full Name'){
                         $bfval['value'] = $user->first_name.' '.$user->last_name;
                    }else if($bfval['label'] == 'Phone Number'){
                         $bfval['value'] = $user->mobile;
                    }else if($bfval['label'] == 'Email'){
                         $bfval['value'] = $user->email;
                    }else if($bfval['label'] == 'Gender'){
                         $bfval['value'] = $user->gender;
                    }else{
                        $bfval['value'] = "";
                    }
                }else{
                   $bfval['value'] = "";
                }
                
            }
        }

        $brand->booking_form = $bookingform;
        $brand->branch_all_data = $branch_all_data;
       
        return sendResponse($brand, 'Data fetch successfully.');
    }
}