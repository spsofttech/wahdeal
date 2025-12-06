<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
use App\Models\OfferType;
use App\Models\UserLocation;
use App\Models\BrandView;
use App\Models\ProductView;

class OfferController extends Controller
{

    public function index(Request $request)
    {
        // --- Validation ---
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
            $uid = '';
            $userdata = (object) [];
        }

        if($uid != ''){
            $user_lat = $userdata->latitude;
            $user_long = $userdata->longitude;
        }else{
            $userlatitude = getstaticlatlong();
            $user_lat = $userlatitude['lat'];
            $user_long = $userlatitude['long'];
        }




        $categoryId  = $request->category ?? null;
        $page        = $request->page;
        $limit       = 2;
        $search      = $request->search ?? null;
        $offer_type  = $request->offer_type ?? null;
        $minDiscount = $request->discount ?? null;
        $minRating   = $request->rating ?? null;

       
        $ot = OfferType::where('status','1')->get();
        
        $categories = Category::where('status', '1')
        ->orderBy('rank', 'asc')
        ->get()
        ->map(function ($cat) {
            if ($cat->name === 'All') {
                $cat->brands_count = Brand::where('status', '1')->count();
            } else {
                $cat->brands_count = $cat->brands()->where('status', '1')->count();
            }
            return $cat;
        });

        // --- Fetch structured offer data ---
        $return_data = offer_data($categoryId, $page, $limit, $user_lat, $user_long, $search, $offer_type, $minDiscount, $minRating);
        $categoriesData = $return_data['categories'];
        $is_nextpage = $return_data['is_nextpage'];

        $filteredCategories = [];
        

        foreach ($categoriesData as $cat) {
            $subcategoriesArray = [];

            foreach ($cat->subcategories ?? [] as $sub) {
                $brandsList = [];
                $subProducts = [];
                $brandBanner = [];
                $ownBanner = [];

                foreach ($sub->brands ?? [] as $brand) {
                    $like_status = '0';
                    if ($user) {
                        $like_status = brand_like($brand->id,$user->id);
                    }

                    // --- Brand discount ---
                    $totBrandDiscount = getBrandTotalDiscountPercentage($brand->id);
                    $totBrandDiscountStr = $totBrandDiscount > 0 ? "{$totBrandDiscount}%" : '';

                    $bdistance = getNearestBranch($brand->id,$user_lat,$user_long);
                    if($bdistance){
                        $bdistanceval = $bdistance->distance_km;
                        $distance_km = round($bdistanceval, 2);
                    }else{
                        $bdistanceval = 0;
                        $distance_km = round($bdistanceval, 2);
                    }

                    $brandsList[] = [
                        'id' => $brand->id,
                        'name' => $brand->name,
                        'icon' => asset('uploads/brand/' . $brand->icon),
                        'description' => $brand->description,
                        'discount_amount' => $totBrandDiscountStr,
                        'distance' => $distance_km ?? null,
                        'like_status' => $like_status,
                        'count' =>  BrandView::totalCount($brand->id),
                        'veg' => $brand->veg_nonveg,
                    ];

                    // --- Brand Products ---
                    $brandProducts = getMaxDiscountProduct($brand->id);

                    // --- Brand banners ---
                    $brandBannerData = getbrandBanner($brand->id, '0');
                    $ownBannerData = getbrandBanner($brand->id, '1');

                    foreach ($brandProducts as &$prod) {

                        $proddata = Product::where('id',$prod['id'])->select('brand_id')->first();
                        $brand_datas = Brand::where('id',$proddata->brand_id)->select('icon')->first();

                        $prod['brand_image'] = asset('uploads/brand/' . $brand_datas->icon);
                        $prod['rating'] = ProductRating::totalRating($prod['id']);
                        $totProdDiscount = getProductDiscountPercentage($prod['id']);
                        $prod['discount_amount'] = $totProdDiscount > 0 ? "{$totProdDiscount}%" : '';

                        $prodLikeStatus = '0';
                        if ($user) {
                            $prodLikeStatus = product_like($prod['id'],$user->id);
                        }
                        $prod['like_status'] = $prodLikeStatus;
                        $pro_near_location = getNearestBranch($proddata->brand_id, $user_lat, $user_long);
                        if($pro_near_location){
                             $prod['location'] = $pro_near_location;
                        }else{
                            $prod['location'] = (object) [];
                        }

                        $prod['count'] = ProductView::totalCount($prod['id']);
                    }

                    if ($brandProducts) $subProducts = array_merge($subProducts, $brandProducts);
                    if ($brandBannerData) $brandBanner = array_merge($brandBanner, $brandBannerData);
                    if ($ownBannerData) $ownBanner = array_merge($ownBanner, $ownBannerData);
                }

                $subcategoriesArray[] = [
                    'subcategory_id' => $sub->id ?? $sub->subcategory_id,
                    'subcategory_name' => $sub->name ?? $sub->subcategory_name,
                    'max_discount' => $sub->max_discount ?? '0',
                    'brands' => $brandsList,
                    'products' => $subProducts,
                    'brand_banner' => $brandBanner,
                    'own_banner' => $ownBanner,
                ];
            }

            $filteredCategories[] = [
                'category_id' => $cat->id,
                'category_name' => $cat->name,
                'category_icon' => $cat->icon,
                'max_discount' => $cat->max_discount ?? '0',
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
                    $item['count'] =  ProductView::totalCount($item['id']);
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

        
        $brand_Ids = [];
        $prod_Ids = [];
        if(!empty($filteredCategories)){
            foreach($filteredCategories as $brandval){
                   foreach ($brandval['subcategories'] as $subcategory) {
                        if (!empty($subcategory['brands'])) {
                            foreach ($subcategory['brands'] as $brand) {
                                $brand_Ids[] = $brand['id'];
                            }
                        }

                        if (!empty($subcategory['products'])) {
                            foreach ($subcategory['products'] as $prod) {
                                $prod_Ids[] = $prod['id'];
                            }
                        }
                   }
            }
        }

        $slider = array();
        if(!empty($brand_Ids)){
             $slider = BrandBanner::where(function ($q) use ($brand_Ids, $prod_Ids) {
                                    $q->whereIn('brand_banners.brand_id', $brand_Ids)
                                    ->orWhereIn('brand_banners.product_id', $prod_Ids);
                                })
                        ->leftJoin('brands', 'brands.id', '=', 'brand_banners.brand_id')
                        ->leftJoin('products', 'products.id', '=', 'brand_banners.product_id')
                        ->where('brand_banners.status', '1')
                         ->where('brand_banners.own_banner', '1')
                         ->select('brand_banners.*', 'brands.name as brand_name','products.name as title')
                        ->orderByDesc('brand_banners.id')
                        ->get();
        }
      
        $data = [
            'offer_type' => $ot,
            'slider' => $slider,
            'category' => $categories,
            'offer' => $filteredCategories,
            'promote' => $promote_data, 
            'user' => $userdata,
            'is_blur' => is_blur($uid)
        ];

        return sendResponsePagination($data, 'Data Fetch Successfully.', $is_nextpage);
    }


    public function offer_type()
    {
        $ot = OfferType::where('status','1')->get();
        return sendResponse($ot, 'Data fetch successfully.');
    }
}