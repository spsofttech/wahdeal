<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
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
use App\Models\Event;


class HomeController extends Controller
{
    public function index(){
        $user = Auth::user();


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

        
        $categoryId = '';
        $page = 1;
        $limit = 2;
        $search = '';


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

        $json_file = asset('uploads/home_lotti.json');
        $is_blur = is_blur($uid);

        $events = Event::select('*', DB::raw("
                    (6371 * acos(
                        cos(radians($user_lat)) *
                        cos(radians(latitude)) *
                        cos(radians(longitude) - radians($user_long)) +
                        sin(radians($user_lat)) *
                        sin(radians(latitude))
                    )) AS distance
                "))
                ->where('status', '1')
                ->orderBy('distance', 'asc')
                ->orderBy('id', 'desc')
                ->take(12)->get();


        return view('index',compact('category','filteredCategories','promote_data','userdata','is_blur','json_file','events'));
    }

     public function get_home_data_page_wise(Request $request){
        $user = Auth::user();


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

        
        $categoryId = '';
        $page = $request->page;
        $limit = 2;
        $search = '';


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

        $messageContent = View::make('ajax_home_data',compact('filteredCategories'))->render(); 

         return response()->json([
            'status' => 'success',
            'message' => $messageContent
        ]);
    }

     public function brands(){
        return view('brands');
    } 

    public function offer(){
        return view('offer');
    }

    public function events(){
        return view('events');
    }

    public function about_brand($id){
        return view('about_brand');
    }

     public function about_us(){
        return view('about_us');
    }

     public function contact_us(){
        return view('contact_us');
    }

     public function about_brand_offer(){
        return view('about_brand_offer');
    }

     public function events_details(){
        return view('events_details');
    }

    public function profile(){
        return view('profile');
    }

    public function shopping(){
        return view('shopping');
    }

    public function hot_deal(){
        return view('hot_deal');
    }

    public function fashion_apparel(){
        return view('fashion_apparel');
    }

    public function order_summary(){
        return view('order_summary');
    }

    public function cart(){
        return view('cart');
    }

     public function categories(){
        return view('categories');
    }

    public function history(){
        return view('history');
    }

   

}