<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\Offer;
use App\Models\Cart;
use App\Models\Size;
use App\Models\Color;
use App\Models\UserAddress;
use App\Models\Brand;
use App\Models\ProductRating;
use App\Models\ProductView;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\CouponCode;
use App\Models\ProductSizeColorPrice;
use App\Models\Branch;

class CartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        $rules = [
            'product_id' => 'required',
            'branch_id' => 'required',
            'qty' => 'required',
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

        $product = Product::where('id',$request->product_id)->first();
        if(!$product){
            return sendError(array(), 'Product not exists'); 
        }

        $branchdataexists = Branch::where('id',$request->branch_id)->first();
        if(!$branchdataexists){
            return sendError(array(), 'Branch not exists'); 
        }

        if($request->size_id){
            $size = Size::where('id',$request->size_id)->first();
            if(!$size){
                return sendError(array(), 'Size not exists'); 
            }
        }

         if($request->color_id){
            $color = Color::where('id',$request->color_id)->first();
            if(!$color){
                return sendError(array(), 'Color not exists'); 
            }
        }

       

        $existscart = Cart::where('user_id',$user->id)->where('product_id',$product->id)->where('status','0');
        if($request->size_id){
             $existscart = $existscart->where('size_id',$request->size_id);
        }

        if($request->color_id){
            $existscart = $existscart->where('color_id',$request->color_id);
        }
        
        $existscart = $existscart->first();



        $productprice = $product->price;
        $newprice = $product->price;    
        if($request->size_id && $request->color_id){
            $exists_size_color_price = ProductSizeColorPrice::where('product_id', $request->product_id)
                        ->where('size_id', $request->size_id)
                        ->where('color_id', $request->color_id)
                        ->first();

            if($exists_size_color_price){
                $productprice = $exists_size_color_price->price;
            }            
        }

   
        
        $discount_val = 0; 
       

        if($existscart){
            $eqty = $existscart->quantity;
            $qty = $eqty + $request->qty;
            $gst = get_gst_charge($request->product_id);


            if($request->offer_id){
                $offer = Offer::where('id',$request->offer_id)->first();
                if(!$offer){
                    return sendError(array(), 'Offer not exists'); 
                }

                if($offer->discount_type == 'fixed'){
                    $discount_val = $offer->discount_value;
                    $newprice = $productprice - $offer->discount_value;
                }else{
                    $discount_val = ($productprice*$offer->discount_value)/100;
                    $newprice = $productprice - $discount_val;
                }
            }

            $discount_val =  $existscart->discount + $discount_val * $request->qty;
            $newprice = $existscart->final_price + $newprice * $request->qty;

            $gst_price = $productprice * $qty * $gst /100;
            $existscart->quantity = $qty;
            $existscart->gst = $gst;
            $existscart->gst_price =  $gst_price;
            $existscart->discount = $discount_val;
            $existscart->final_price = $newprice;
            $existscart->save();

        }else{

            $qty = $request->qty;
            $gst = get_gst_charge($request->product_id);

            if($request->offer_id){
                $offer = Offer::where('id',$request->offer_id)->first();
                if(!$offer){
                    return sendError(array(), 'Offer not exists'); 
                }

                if($offer->discount_type == 'fixed'){
                    $discount_val = $offer->discount_value;
                    $newprice = $productprice - $offer->discount_value;
                }else{
                    $discount_val = ($productprice*$offer->discount_value)/100;
                    $newprice = $productprice - $discount_val;
                }
            }

            $discount_val =  $discount_val * $request->qty;
            $newprice = $newprice * $request->qty;

            $cart_data = new Cart;
            $cart_data->user_id = $user->id;
            $cart_data->product_id = $request->product_id;
            $cart_data->branch_id = $request->branch_id;

            if($request->offer_id){
                $cart_data->offer_id = $request->offer_id;
            }

            if($request->size_id){
                $cart_data->size_id = $request->size_id;
            }

            if($request->color_id){
                    $cart_data->color_id = $request->color_id;
            }
            
            $gst_price = $productprice * $qty * $gst /100;


            $cart_data->quantity = $qty;
            $cart_data->price = $productprice;
            $cart_data->gst = $gst;
            $cart_data->gst_price =  $gst_price;
            $cart_data->discount = $discount_val;
            $cart_data->final_price = $newprice;
            $cart_data->save();
        }


        $data = Cart::where('user_id',$user->id)->where('product_id',$product->id)->where('status','0')->first();
        return sendResponse($data, 'Product added to cart successfully.');
        
    }

    public function my_cart(Request $request)
    {
         $today = Carbon::today()->toDateString();
        $user = Auth::guard('api')->user();
        if (!$user) {
            return sendError(array(), 'User not exists'); 
        }

        $couponcode = $request->coupon_code;

        if($couponcode != ''){
            $coupon_code_data = CouponCode::where('code',$couponcode)
             ->where('type','2')
            ->where('status','1')
            ->first();

            if(!$coupon_code_data){
                return sendError(array(), 'Coupon code not valid'); 
            }
        }
        
        $cart = get_cart($user,$couponcode);


        $all_coupon_code = CouponCode::whereDate('end_date', '>=', $today)->where('type','2')->where('status','1')->get();
        $all_coupon_data_array = array();
        foreach ($all_coupon_code as $val) {
            $alreadycouponuser =  usedcoupon($val->id,$user->id);
            $uselimit = $val->usage_limit;

            if($uselimit <= $alreadycouponuser){
                continue;
            }

            $all_coupon_data_array[] = $val;
        }


        $cart['all_coupon'] = $all_coupon_data_array;
        return sendResponse($cart, 'Data fetch successfully.');
    }

    public function add_cart_item(Request $request)
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
        if (!$user) {
            return sendError(array(), 'User not exists'); 
        }

        $existscart = Cart::where('user_id',$user->id)->where('id',$request->id)->where('status','0')->first();
        if (!$existscart) {
            return sendError(array(), 'Cart item not exists'); 
        }


        $product = Product::where('id',$existscart->product_id)->first();
        if(!$product){
            return sendError(array(), 'Product not exists'); 
        }



        $productprice = $product->price;
        $newprice = $product->price; 
        $gst = get_gst_charge($existscart->product_id);   
        if($existscart->size_id && $existscart->color_id){
            $exists_size_color_price = ProductSizeColorPrice::where('product_id', $existscart->product_id)
                        ->where('size_id', $existscart->size_id)
                        ->where('color_id', $existscart->color_id)
                        ->first();

            if($exists_size_color_price){
                $productprice = $exists_size_color_price->price;
            }            
        }

  
        $discount_val = 0; 
       
        $eqty = $existscart->quantity;
        $qty = $eqty + 1;


        if($existscart->offer_id){
            $offer = Offer::where('id',$existscart->offer_id)->first();
           
            if($offer->discount_type == 'fixed'){
                $discount_val = $offer->discount_value;
                $newprice = $productprice - $offer->discount_value;
            }else{
                $discount_val = ($productprice*$offer->discount_value)/100;
                $newprice = $productprice - $discount_val;
            }
        }

        $gst_price = $productprice * $qty * $gst /100;
        $discount_val =  $existscart->discount + $discount_val;
        $newprice = $existscart->final_price + $newprice;
        $existscart->quantity = $qty;
        $existscart->gst = $gst;
        $existscart->gst_price = $gst_price;
        $existscart->discount = $discount_val;
        $existscart->final_price = $newprice;
        $existscart->save();

        

        $cart = get_cart($user);
        return sendResponse($cart, 'Data fetch successfully.');
        
    }

    public function minus_cart_item(Request $request)
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
        if (!$user) {
            return sendError(array(), 'User not exists'); 
        }

        $existscart = Cart::where('user_id',$user->id)->where('id',$request->id)->where('status','0')->first();
        if (!$existscart) {
            return sendError(array(), 'Cart item not exists'); 
        }


        $product = Product::where('id',$existscart->product_id)->first();
        if(!$product){
            return sendError(array(), 'Product not exists'); 
        }


        $gst = get_gst_charge($existscart->product_id);

        $productprice = $product->price;
        $newprice = $product->price;    
        if($existscart->size_id && $existscart->color_id){
            $exists_size_color_price = ProductSizeColorPrice::where('product_id', $existscart->product_id)
                        ->where('size_id', $existscart->size_id)
                        ->where('color_id', $existscart->color_id)
                        ->first();

            if($exists_size_color_price){
                $productprice = $exists_size_color_price->price;
            }            
        }

        $discount_val = 0; 
       
        $eqty = $existscart->quantity;
        $qty = $eqty - 1;


        if($existscart->offer_id){
            $offer = Offer::where('id',$existscart->offer_id)->first();
           
            if($offer->discount_type == 'fixed'){
                $discount_val = $offer->discount_value;
                $newprice = $productprice - $offer->discount_value;
            }else{
                $discount_val = ($productprice*$offer->discount_value)/100;
                $newprice = $productprice - $discount_val;
            }
        }

        $gst_price = $productprice * $qty * $gst /100;
        $discount_val =  $existscart->discount - $discount_val;
        $newprice = $existscart->final_price - $newprice;

        $existscart->quantity = $qty;
        $existscart->gst = $gst;
        $existscart->gst_price = $gst_price;
        $existscart->discount = $discount_val;
        $existscart->final_price = $newprice;
        $existscart->save();

        

        if($qty <= 0){
           Cart::where('id',$request->id)->delete(); 
        }


        $cart = get_cart($user);
        return sendResponse($cart, 'Data fetch successfully.');
        
    }

    public function get_product_size_color(Request $request){
        $rules = [
            'id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();
        if (!$user) {
            $uid = 0;
        }else{
            $uid = $user->id;
        }

        $product = Product::where('id',$request->id)->first();
        if(!$product){
            return sendError(array(), 'Product not exists'); 
        }

        $product_price = $product->price;

        $productsize = ProductSize::join('sizes', 'product_sizes.size_id', '=', 'sizes.id')
        ->where('product_sizes.product_id',$request->id)->select('sizes.*')->get();
        $productcolor = ProductColor::join('colors', 'product_colors.color_id', '=', 'colors.id')
        ->where('product_colors.product_id',$request->id)->select('colors.*')->get();



        if($request->size_id && $request->color_id){
            $exists_size_color_price = ProductSizeColorPrice::where('product_id', $request->id)
                        ->where('size_id', $request->size_id)
                        ->where('color_id', $request->color_id)
                        ->first();

            if($exists_size_color_price){
                $product_price = $exists_size_color_price->price;
            }            
        }else{
            if($productsize->isNotEmpty() && $productcolor->isNotEmpty()){
                $sizeid = $productsize[0]['id'];
                $colorid = $productcolor[0]['id'];

                $exists_size_color_price = ProductSizeColorPrice::where('product_id', $request->id)
                        ->where('size_id', $sizeid)
                        ->where('color_id', $colorid)
                        ->first();

                if($exists_size_color_price){
                    $product_price = $exists_size_color_price->price;
                } 
            }
        }

        

        $offer = Offer::where('product_id', $request->id)->where('status', '1')
                                ->whereDate('start_date', '<=', now())
                                ->whereDate('end_date', '>=', now())
                                ->orderByDesc('id')
                                ->first();
                                
        $newprice = 0;
        $discount_amt = 0;                    
        if($offer){
            if($offer->discount_type == 'fixed'){
                $discount_val = $offer->discount_value;
                $newprice = $product_price - $offer->discount_value;
                $discount_amt = ($discount_val / $product_price) * 100;
            }else{
                $discount_val = ($product_price*$offer->discount_value)/100;
                $newprice = $product_price - $discount_val;

                $discount_amt = $offer->discount_value;
            }
        }

        if($discount_amt > 0){
            $discount_text = "{$discount_amt}%";
        }else{
            $discount_text = "";
        }
        

         if($newprice == 0){
            $data['old_price'] = "0";
            $data['price'] = (string) $product_price;
            $data['discount'] = $discount_text;
        }else{
            $data['old_price'] = $product_price;
            $data['price'] = (string) $newprice;
             $data['discount'] = $discount_text;
        }

       

       
        $data['size'] = $productsize;
        $data['color'] = $productcolor;

        return sendResponse($data, 'Data fetch successfully.');
    }

    public function change_cart_item_size(Request $request){
        $rules = [
            'id' => 'required',
            'size_id' => 'required',
            'color_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();


        $size = Size::where('id',$request->size_id)->first();
        if(!$size){
            return sendError(array(), 'Size not exists'); 
        }


        $cart_data = Cart::where('id',$request->id)->where('user_id',$user->id)->where('status','0')->first();
        if(!$cart_data){
            return sendError(array(), 'Cart item not exists'); 
        }

      

        $existscart = Cart::where('user_id',$user->id)
        ->where('product_id',$cart_data->product_id)
        ->where('size_id',$request->size_id)
        ->where('color_id',$request->color_id)
        ->where('status','0')
        ->first();
        


        $product = Product::where('id',$cart_data->product_id)->first();
        $gst = get_gst_charge($cart_data->product_id);


        $productprice = $product->price;
        $newprice = $product->price;    
        if($request->size_id && $request->color_id){
            $exists_size_color_price = ProductSizeColorPrice::where('product_id', $cart_data->product_id)
                        ->where('size_id', $request->size_id)
                        ->where('color_id', $request->color_id)
                        ->first();

            if($exists_size_color_price){
                $productprice = $exists_size_color_price->price;
            }            
        }


  
        $discount_val = 0; 
       

        if($existscart){
            $eqty = $existscart->quantity;
            $qty = $eqty + $cart_data->quantity;


            if($cart_data->offer_id){
                $offer = Offer::where('id',$cart_data->offer_id)->first();
                if(!$offer){
                    return sendError(array(), 'Offer not exists'); 
                }

                if($offer->discount_type == 'fixed'){
                    $discount_val = $offer->discount_value;
                    $newprice = $productprice - $offer->discount_value;
                }else{
                    $discount_val = ($productprice*$offer->discount_value)/100;
                    $newprice = $productprice - $discount_val;
                }
            }

            $gst_price = $productprice * $qty * $gst /100;
            $discount_val =  $existscart->discount + $discount_val * $cart_data->quantity;
            $newprice = $existscart->final_price + $newprice * $cart_data->quantity;

            $existscart->price = $productprice;
            $existscart->gst = $gst;
            $existscart->gst_price = $gst_price;
            $existscart->quantity = $qty;
            $existscart->discount = $discount_val;
            $existscart->final_price = $newprice;
            $existscart->save();

            if($existscart->id !=  $cart_data->id){
                $cart_data->delete();
            }
            
        }else{

           
            if($cart_data->offer_id){
                $offer = Offer::where('id',$cart_data->offer_id)->first();
                if(!$offer){
                    return sendError(array(), 'Offer not exists'); 
                }

                if($offer->discount_type == 'fixed'){
                    $discount_val = $offer->discount_value;
                    $newprice = $productprice - $offer->discount_value;
                }else{
                    $discount_val = ($productprice*$offer->discount_value)/100;
                    $newprice = $productprice - $discount_val;
                }
            }

            $gst_price = $productprice * $cart_data->quantity * $gst /100;
            $discount_val =  $discount_val * $cart_data->quantity;
            $newprice = $newprice * $cart_data->quantity;


            $update['size_id'] = $request->size_id;
            $update['color_id'] = $request->color_id;
            $update['price'] = $productprice;
            $update['gst'] = $gst;
            $update['gst_price'] = $gst_price;
            $update['discount'] = $discount_val;
            $update['final_price'] = $newprice;
            $cart_data->update($update);
        }



        $cart = get_cart($user);
        return sendResponse($cart, 'Data fetch successfully.');
    }



    public function delete_cart_item(Request $request){
        $rules = [
            'id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();

        $cart_data = Cart::where('id',$request->id)->where('status','0')->first();
        if(!$cart_data){
            return sendError(array(), 'Cart item not exists'); 
        }

        $cart_data->delete();
       
        $cart = get_cart($user);
        return sendResponse($cart, 'Item deleted successfully.');
    }



    public function get_cart_product_brand(Request $request){
        $user = Auth::guard('api')->user();
        $cart_data = array();
        if ($user) {
             $cart_data = Cart::join('products', 'carts.product_id', '=', 'products.id')
                        ->select(
                            'carts.product_id',
                            'products.brand_id',
                            DB::raw('SUM(carts.quantity) as total_quantity')
                        )
                        ->where('carts.user_id', $user->id)
                        ->where('carts.status', '0')
                        ->groupBy('carts.product_id', 'products.brand_id')
                        ->get();
        }

        return sendResponse($cart_data, 'Data fetch successfully.');
    }

}
