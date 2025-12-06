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
use App\Models\ProductView;
use App\Models\Branch;

class HomeController extends Controller
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
            $user_lat = $userdata->latitude;
            $user_long = $userdata->longitude;
        }else{
            $uid = '0';
            $userdata = (object) [];
            $userlatitude = getstaticlatlong();
            $user_lat = $userlatitude['lat'];
            $user_long = $userlatitude['long'];
        }

        
        $categoryId = $request->category ?? null;
        $page = $request->page;
        $limit = 2;
        $search = $request->search ?? null;


       $category = Category::where('status', '1')
        ->orderBy('rank', 'asc')
        ->get()
        ->map(function ($cat) {
            if ($cat->name === 'All') {
                 $cat->brands_count = Brand::
                join('categories', 'brands.category_id', '=', 'categories.id')
                ->where('brands.status', '1')->count();
            } else {
                $cat->brands_count = $cat->brands()->where('status', '1')->count();
            }
            return $cat;
        });

        // Fetch structured home data with search
        $return_data = home_data($categoryId, $page, $limit, $user_lat, $user_long, $search);

        $categories = $return_data['categories'];
        $all_data = $return_data['all_data'];
        $count = count($all_data);
        $total_page = ceil($count / $limit);
        $is_nextpage = $total_page > $page ? '1' : '0';

        $filteredCategories = [];

        foreach ($categories as $categoryval) {
            $subcategoriesArray = [];

            foreach ($categoryval->subcategories ?? [] as $sub) {
                $filteredBrands = $sub->brands
                    ->sortByDesc(fn($brand) => (float)$brand->max_discount)
                    ->values();

                $brandsList = [];
                $subProducts = []; 
                $brand_Banner = [];
                $own_Banner = [];
                $BookingList = [];
                $AppointmentList = [];
                

                foreach ($filteredBrands as $brand) {
                    $likestatus = '0';
                    if ($user) {
                        $likestatus = brand_like($brand->id,$user->id);
                    }

                    $totbranddiscount = getBrandTotalDiscountPercentage($brand->id);
                    if($totbranddiscount  <= '0'){
                            $tot_brand_discount = '';
                    }else{
                            $tot_brand_discount = (string) $totbranddiscount.'%';
                    }


                    $bookingbranch = getNearestBookingBranch($brand->id,$user_lat, $user_long);
                    if($bookingbranch){

                        $bookingbranchlikestatus = '0';
                        if ($user) {
                            $bookingbranchlikestatus = branch_like($bookingbranch->id,$user->id);
                        }

                        $BookingList[] = [
                            'id' => $brand->id,
                            'name' => $brand->name,
                            'icon' => asset('uploads/brand/' . $brand->icon),
                            'like_status' => $bookingbranchlikestatus,
                            'count' =>  BrandView::totalCount($brand->id),
                            'veg' => $brand->veg_nonveg,
                            'location'=>$bookingbranch
                        ];
                    }
                    

                    $appointmentbranch = getNearestAppointmentBranch($brand->id,$user_lat, $user_long);
                    if($appointmentbranch){
                        $appointmentbranchlikestatus = '0';
                        if ($user) {
                            $appointmentbranchlikestatus = branch_like($appointmentbranch->id,$user->id);
                        }

                        $AppointmentList[] = [
                            'id' => $brand->id,
                            'name' => $brand->name,
                            'icon' => asset('uploads/brand/' . $brand->icon),
                            'like_status' => $appointmentbranchlikestatus,
                            'count' =>  BrandView::totalCount($brand->id),
                            'veg' => $brand->veg_nonveg,
                            'location'=>$appointmentbranch
                        ];
                    }
                   


                    $brandsList[] = [
                        'id' => $brand->id,
                        'name' => $brand->name,
                        'icon' => asset('uploads/brand/' . $brand->icon),
                        'description' => $brand->description,
                        'discount_amount' => $tot_brand_discount,
                        'distance' => $brand->distance_km,
                        'like_status' => $likestatus,
                        'count' =>  BrandView::totalCount($brand->id),
                        'veg' => $brand->veg_nonveg,
                    ];


                    $brandProducts = getMaxDiscountProduct($brand->id);
                    $brandBanner = getbrandBanner($brand->id, '0');
                    $OwnBanner = getbrandBanner($brand->id, '1');

                    foreach ($brandProducts as &$prod) {
                        $prod['brand_image'] =  asset('uploads/brand/' . $prod['brand_image']);

                        $productlikestatus = '0';
                        $prod['rating'] = ProductRating::totalRating($prod['id']);

                        $totproductdiscount = getProductDiscountPercentage($prod['id']);
                        if($totproductdiscount <= '0'){
                                $tot_product_discount = '';
                        }else{
                                $tot_product_discount = (string) $totproductdiscount.'%';
                        }

                         $prod['discount_amount'] = $tot_product_discount;


                        if ($user) {
                            $productlikestatus = product_like($prod['id'],$user->id);
                        }  

                        $prod['like_status'] = $productlikestatus;
                        $prod['count'] = ProductView::totalCount($prod['id']);

                        $pro_near_location = '';
                        if($prod['offer'] != null){
                            $pro_near_location = getNearestOfferBranch($prod['offer']->id, $user_lat, $user_long);
                        }


                        if($pro_near_location){
                            $prod['location'] = $pro_near_location;
                        }else{
                            $prod['location'] = (object) [];
                        }


                       
                    }

                    if ($brandProducts) $subProducts = array_merge($subProducts, $brandProducts);
                    if ($brandBanner) $brand_Banner = array_merge($brand_Banner, $brandBanner);
                    if ($OwnBanner) $own_Banner = array_merge($own_Banner, $OwnBanner);
                    
                }

                $subcategoriesArray[] = [
                    'subcategory_id' => $sub->id ?? $sub->subcategory_id,
                    'subcategory_name' => $sub->name ?? $sub->subcategory_name,
                    'max_discount' => $sub->max_discount ?? '0',
                    'brands' => $brandsList,
                    'products' => $subProducts,
                    'brand_banner' => $brand_Banner,
                    'own_banner' => $own_Banner,
                    'booking' => $BookingList,
                    'appointment' => $AppointmentList,
                ];
            }

            $filteredCategories[] = [
                'category_id' => $categoryval->id,
                'category_name' => $categoryval->name,
                'category_icon' => $categoryval->icon,
                'max_discount' => $categoryval->max_discount ?? '0',
                'subcategories' => $subcategoriesArray,
            ];
        }

        // Promote data
        $brand_promote = Brand::
        join('categories', 'brands.category_id', '=', 'categories.id')
        ->where('brands.status', '1')
            ->where('brands.is_promote', '1')
            ->select('brands.id', 'brands.name', 'brands.icon','brands.veg_nonveg')
            ->get()
            ->map(fn($brand) => [
                'id' => $brand->id,
                'name' => $brand->name,
                'icon' => $brand->image_url,
                'veg' => $brand->veg_nonveg,
                'type' => 'brand'
            ]);

        $product_promote = Product::
         join('categories', 'products.category_id', '=', 'categories.id')
        ->where('products.status', '1')
            ->where('products.is_promote', '1')
            ->select('products.id', 'products.name', 'products.image','products.veg_nonveg')
            ->get()
            ->map(fn($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'icon' => $product->image_url,
                'veg' => $product->veg_nonveg,
                'type' => 'product'
            ]);

        $promote_data = $brand_promote->merge($product_promote)->values();

        if ($promote_data->isNotEmpty()) {
            $promote_data = $promote_data->map(function ($item) use ($uid) {
                $prtype = $item['type'];
                if ($prtype == 'brand') {
                    $totdiscount = getBrandTotalDiscountPercentage($item['id']);
                    $likestatus = brand_like($item['id'],$uid);
                    $item['count'] = BrandView::totalCount($item['id']);
                } else {
                    $totdiscount = getProductDiscountPercentage($item['id']);
                    $likestatus = product_like($item['id'],$uid);
                    $item['count'] = ProductView::totalCount($item['id']);
                }

               if($totdiscount <= '0'){
                    $totdiscount = '';
               }else{
                    $totdiscount = (string) $totdiscount.'%';
               }
                $item['discount_amount'] = $totdiscount;
                $item['like_status'] = $likestatus;
                return $item;
            });
        }

        $data['category'] = $category;
        $data['offer'] = $filteredCategories;
        $data['promote'] = $promote_data;
        $data['json_file'] = asset('uploads/home_lotti.json');
        $data['user'] =  $userdata;
        $data['is_blur'] = is_blur($uid);

        return sendResponsePagination($data, 'Data Fetch Successfully.', $is_nextpage);
    }


    public function like_unlike(Request $request){
        $rules = [
            'status' => 'required',
        ];
        $validator = Validator::make($request->all() , $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError(array(),$errorString);
        }else{
            $user = auth()->user();

            if($request->brand_id){
                $brand = Brand::where('id', $request->brand_id)->first();
                if(!$brand){
                    return sendError(array(), 'Brand not exists'); 
                }

                UserLike::where('brand_id', $request->brand_id)->where('user_id',$user->id)->delete();
                $data['user_id'] = $user->id;
                $data['brand_id'] = $request->brand_id;
                $data['status'] = $request->status;
                UserLike::create($data);
            }

            if($request->product_id){
                 $product = Product::where('id', $request->product_id)->first();
                if(!$product){
                    return sendError(array(), 'Product not exists'); 
                }

                UserLike::where('product_id', $request->product_id)->where('user_id',$user->id)->delete();
                $data['user_id'] = $user->id;
                $data['product_id'] = $request->product_id;
                $data['status'] = $request->status;
                UserLike::create($data);
            }

            if($request->branch_id){
                $branch = Branch::where('id', $request->branch_id)->first();
                if(!$branch){
                    return sendError(array(), 'Branch not exists'); 
                }

                UserLike::where('branch_id', $request->branch_id)->where('user_id',$user->id)->delete();
                $data['user_id'] = $user->id;
                $data['branch_id'] = $request->branch_id;
                $data['status'] = $request->status;
                UserLike::create($data);
            }

            if($request->status == '1'){
                $msg = 'Added to wishlist';
            }else{
                $msg = 'Remove from wishlist';
            }

            return sendResponse(array(), $msg); 

        }
       
    }

}