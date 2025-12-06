<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\ProductRating;
use App\Models\BrandBanner;
use App\Models\Product;
use App\Models\UserLike;
use App\Models\UserLocation;
use App\Models\BrandView;
use App\Models\OfferType;
use App\Models\Offer;
use App\Models\ProductView;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\UserAddress;
use App\Models\ProductSizeColorPrice;
use App\Models\ShortLink;

class FashionController extends Controller
{
    public function index(Request $request)
    {
        $rules = [
            'page' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();

         if($user){
             $uid = $user->id;
             $location = UserLocation::where('user_id',$uid)->where('status','1')->first();

             if($location){
                $update['state']= $location->state;
                $update['city']= $location->city;
                $update['latitude']= $location->latitude;
                $update['longitude'] = $location->longitude;
                User::where('id', $user->id)->update($update);
             }

            $userdata = User::where('id',$user->id)->select('first_name','last_name','image','state','city','latitude','longitude','promo_code','wallet_balance')->first();
        }else{
            $uid = '0';
            $userdata = (object) [];
        }

        if($uid != '0'){
            $user_lat = $userdata->latitude;
            $user_long = $userdata->longitude;
        }else{
            $userlatitude = getstaticlatlong();
            $user_lat = $userlatitude['lat'];
            $user_long = $userlatitude['long'];
        }


        $categoryId = $request->category ?? null;
      
        $page = $request->page;
        $limit = 2;
        $search = $request->search ?? null;


       $category = Category::where('status', '1')
        ->where(function ($q) {
            $q->where('is_fashion', '1')
            ->orWhere('name', 'All');
        })
        ->orderBy('rank', 'asc')
        ->get()
        ->map(function ($cat) {
            if ($cat->name === 'All') {
                $cat->brands_count = Brand::join('categories', 'brands.category_id', '=', 'categories.id')
                    ->where('categories.is_fashion', '1')
                    ->where('brands.status', '1')
                    ->count();
            } else {
                $cat->brands_count = $cat->brands()->where('status', '1')->count();
            }

            return $cat;
        });

        // Fetch structured home data with search
        $return_data = fashion_home_data($uid,$categoryId, $page, $limit, $user_lat, $user_long, $search);

        $offer = $return_data['data'];
        $is_nextpage = $return_data['is_nextpage'];
        

        $data['category'] = $category;
        $data['offer'] = $offer;
         $data['user'] =  $userdata;
       

        return sendResponsePagination($data, 'Data Fetch Successfully.', $is_nextpage);
    }

    public function fashion_category_product(Request $request)
    {
        $rules = [
            'page' => 'required|integer',
            'category_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();

        if($user){
            $uid = $user->id;
            $userdata = User::where('id',$user->id)->select('first_name','last_name','image','state','city','latitude','longitude','promo_code','wallet_balance')->first();
        }else{
            $uid = '0';
            $userdata = (object) [];
        }

        if($uid != '0'){
            $user_lat = $userdata->latitude;
            $user_long = $userdata->longitude;
        }else{
            $userlatitude = getstaticlatlong();
            $user_lat = $userlatitude['lat'];
            $user_long = $userlatitude['long'];
        }


        $OfferType = OfferType::where('status','1')->get();
        $category = Category::where('id', $request->category_id)->where('is_fashion', '1')->first();

        $subcategory = SubCategory::select('id','name','icon')->where('category_id', $request->category_id)->get();


        $brand = Brand::where('category_id',$request->category_id)
        ->whereHas('products', function ($q) {
                $q->where('status', '1');
        });
        if($request->subcategory_id){
           $brand->where('subcategory_id',$request->subcategory_id);
        }
        $brand = $brand->select('id','category_id','subcategory_id','name','icon','banner_image')->get();


        $filters['discount'] = $request->discount;
        $filters['rating']  = $request->rating;
        $filters['offer_type']   = $request->offer_type;


        $productdata = category_product($uid, $request->category_id, $request->subcategory_id, $request->brand_id, $request->page, 10, $filters, $user_lat, $user_long);
        $product = $productdata['data'];

        $discount_per = getCategoryDiscountPercentage($request->category_id);


        $data['subcategory'] = $subcategory;
        $data['brand'] = $brand;
        $data['product'] = $product;
        $data['OfferType'] = $OfferType;
        $data['discount_per'] = $discount_per;
        $is_nextpage = $productdata['is_nextpage'];
    
        return sendResponsePagination($data, 'Data Fetch Successfully.', $is_nextpage);
    }

    public function fashion_product_detail(Request $request)
    {
        $rules = [
            'id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }


        $product = Product::where('id',$request->id)->first();
        if(!$product){
            return sendError(array(), 'Product not exists'); 
        }



        $user = Auth::guard('api')->user();

        if($user){
            $uid = $user->id;
            $userdata = User::where('id',$uid)->select('first_name','last_name','image','state','city','latitude','longitude','promo_code','wallet_balance')->first();
            $useraddress = UserAddress::where('user_id',$uid)->first();
        }else{
            $uid = '0';
            $userdata = (object) [];
            $useraddress = (object) [];
        }

        if($uid != '0'){
            $user_lat = $userdata->latitude;
            $user_long = $userdata->longitude;
        }else{
            $userlatitude = getstaticlatlong();
            $user_lat = $userlatitude['lat'];
            $user_long = $userlatitude['long'];
        }

        $product_price = $product->price;
        $productsize = ProductSize::join('sizes', 'product_sizes.size_id', '=', 'sizes.id')
        ->where('product_sizes.product_id',$request->id)->select('sizes.*')->get();
        $productcolor = ProductColor::join('colors', 'product_colors.color_id', '=', 'colors.id')
        ->where('product_colors.product_id',$request->id)->select('colors.*')->get();



         $offer = Offer::where('product_id', $request->id)->where('status', '1')
                                ->whereDate('start_date', '<=', now())
                                ->whereDate('end_date', '>=', now())
                                ->orderByDesc('id')
                                ->first();
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

        $newprice = 0;                    
        if($offer){
            if($offer->discount_type == 'fixed'){
                $newprice = $product_price - $offer->discount_value;
            }else{
                $discount_val = ($product_price*$offer->discount_value)/100;
                $newprice = $product_price - $discount_val;
            }

            $pro_near_location = getNearestOfferBranch($offer->id, $user_lat, $user_long);
            if($pro_near_location){
                $product->location = $pro_near_location;
            }else{
                $product->location = (object) [];
            }


        }else{
            $pro_near_location = getNearestBranch($product->brand_id, $user_lat, $user_long);
            if($pro_near_location){
                $product->location = $pro_near_location;
            }else{
                $product->location = (object) [];
            }
        }

        if($newprice == 0){
            $product->old_price = "0";
            $product->price = $product_price;
        }else{
            $product->old_price = $product_price;
            $product->price = $newprice;
        }


        $product->description = strip_tags($product->description);
        $product->deal_count = fashion_deal_count($product->id);
        $product->view_count = ProductView::totalCount($product->id);
        $product->rating = ProductRating::totalRating($product->id);
        $product->like_status = $uid ? product_like($product->id, $uid) : '0';
        $product->offer = $offer ?? (object)[];
        $product->size = ProductSize::join('sizes', 'product_sizes.size_id', '=', 'sizes.id')
        ->where('product_sizes.product_id',$product->id)->select('sizes.*')->get();

        $product->color = ProductColor::join('colors', 'product_colors.color_id', '=', 'colors.id')
        ->where('product_colors.product_id',$product->id)->select('colors.*')->get();

        $review = ProductRating::with('user:id,first_name,last_name,image')
                ->where('product_id', $product->id)
                ->orderByDesc('id')
                ->take(4)
                ->get();

        if(!empty($review)){
            foreach($review as &$rval){
                $rval->is_added = '0'; 
                if($user){
                    $thisuseradd = ProductRating::where('id',$rval->id)->where('user_id',$user->id)->where('product_id',$rval->product_id)->first();
                    if($thisuseradd){
                        $rval->is_added = '1'; 
                    }
                }
                
            }
        } 


        $similarProducts = similar_brand_product($product->id,$product->brand_id,$product->category_id);
         if(!empty($similarProducts)){
            foreach ($similarProducts as &$val) {
                $branddata = Brand::find($val['brand_id']);
                $prodLikeStatus = '0';
                if ($user) {
                    $prodLikeStatus = product_like($val['id'], $user->id);
                }

                $pro_near_location = getNearestBranch($val['brand_id'], $user_lat, $user_long);
                if($pro_near_location){
                    $val['location'] = $pro_near_location;
                }else{
                    $val['location'] = (object) [];
                }


                $offer = $val['offers'];
                $newprice = 0;                    
                if($offer && is_object($offer) && count((array)$offer) > 0){
                    if($offer->discount_type == 'fixed'){
                        $newprice = $val['price'] - $offer->discount_value;
                    }else{
                        $discount_val = ($val['price']*$offer->discount_value)/100;
                        $newprice = $val['price'] - $discount_val;
                    }
                }

                if($newprice == 0){
                    $old_price = "0";
                    $price = $val['price'];
                }else{
                    $old_price = $val['price'];
                    $price = $newprice;
                }

                $val['price'] = (string)$price;
                $val['old_price'] = (string)$old_price;
                $val['like_status'] = $prodLikeStatus;
                $val['view_count'] = ProductView::totalCount($val['id']);
                $val['deal_count'] = fashion_deal_count($val['id']);
                $val['rating'] = ProductRating::totalRating($val['id']);
                $val['brand_name'] = $branddata->name;
                $val['brand_image'] = $branddata ? asset('uploads/brand/' . $branddata->icon) : '';
            }
        }



        $OtherProducts = other_brand_product($product->brand_id,$product->category_id);

        if(!empty($OtherProducts)){
             foreach ($OtherProducts as &$vals) {
                $branddata = Brand::find($vals['brand_id']);
                $prodLikeStatus = '0';
                if ($user) {
                    $prodLikeStatus = product_like($vals['id'], $user->id);
                }

                $pro_near_location = getNearestBranch($vals['brand_id'], $user_lat, $user_long);
                if($pro_near_location){
                    $vals['location'] = $pro_near_location;
                }else{
                    $vals['location'] = (object) [];
                }


                $offer = $vals['offers'];
                $newprice = 0;                    
                if($offer != (object)[]){
                    if($offer->discount_type == 'fixed'){
                        $newprice = $vals['price'] - $offer->discount_value;
                    }else{
                        $discount_val = ($vals['price']*$offer->discount_value)/100;
                        $newprice = $vals['price'] - $discount_val;
                    }
                }


                 if($newprice == 0){
                    $other_old_price = "0";
                    $other_new_price = $vals['price'];
                }else{
                    $other_old_price = $vals['price'];
                    $other_new_price = $newprice;
                }




                $vals['price'] = (string) $other_new_price;
                $vals['old_price'] = (string)$other_old_price;
                $vals['like_status'] = $prodLikeStatus;
                $vals['view_count'] = ProductView::totalCount($vals['id']);
                $vals['deal_count'] = fashion_deal_count($vals['id']);
                $vals['rating'] = ProductRating::totalRating($vals['id']);
                $vals['brand_name'] = $branddata->name;
                $vals['brand_image'] = $branddata ? asset('uploads/brand/' . $branddata->icon) : '';
            }
        }

        $product->review = $review ?? array();
        $product->similar_product = $similarProducts ?? array();
        $product->other_product = $OtherProducts ?? array();
        $product->product_images = ProductImage::where('product_id',$request->id)->get();
        $product->delivery_detail = $useraddress;
        $product->delivery_by = delivery_by();


        $rating_exists = '0';
        if($uid != '0'){
            $ratingexists = ProductRating::where('product_id',$request->id)->where('user_id',$uid)->first();
            if($ratingexists){
                $rating_exists = '1';
            }

            $existsproductview = ProductView::where('product_id',$request->id)->where('user_id',$uid)->first();
            if(!$existsproductview){
                $pviewdata = array(
                            "product_id"=>$request->id,
                            "user_id"=>$uid,
                        );
                        ProductView::create($pviewdata);
            }

            $brandviewexists = BrandView::where('brand_id',$product->brand_id)->where('user_id',$uid)->first();
            if(!$brandviewexists){
                $brandviewdata = array(
                            "brand_id"=>$product->brand_id,
                            "user_id"=>$uid,
                        );

                BrandView::create($brandviewdata);
            }
        }
        $product->rating_exists = $rating_exists;

        $p_link = ShortLink::where('type','shoping_product')->where('item_id',$product->id)->first();
        $product->product_website = url("/d/{$p_link->code}/{$product->id}/shoping_product");
        

        return sendResponse($product, 'Data fetch successfully.');


    }
}
