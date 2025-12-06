<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use App\Models\UserDeal;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\Brand;
use App\Models\Branch;
use App\Models\Offer;
use App\Models\User;
use App\Models\UserLike;
use App\Models\BrandView;
use App\Models\ProductView;

class DealController extends Controller
{

    public function redeem(Request $request)
    {
        $rules = [
            'qr_text' => 'required',
            'product_id' => 'required',
            'offer_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();
        $today = Carbon::today();
        $qr_text = $request->qr_text;
        $product_id = $request->product_id;
        $offer_id = $request->offer_id;

        $branch = Branch::where('qr_code_text',$qr_text)->first();
        if(!$branch){
             return sendError(array(), 'Branch not exists'); 
        }

        $Offer = Offer::where('id',$offer_id)->first();
        if(!$Offer){
             return sendError(array(), 'Offer not exists'); 
        }

        if ($Offer->end_date && Carbon::parse($Offer->end_date)->lt($today)) {
            return sendError([], 'Offer has expired');
        }

        if($Offer->product_id != $product_id){
            return sendError(array(), 'Product not match with offer'); 
        }

        $exists = UserDeal::where('user_id',$user->id)->where('branch_id',$branch->id)
        ->where('offer_id',$offer_id)->where('product_id',$product_id)->first();

        if($exists){
            return sendError(array(), 'You have already apply this offer'); 
        }

    
        $dealdata = new UserDeal;
        $dealdata->user_id = $user->id;
        $dealdata->branch_id = $branch->id;
        $dealdata->offer_id = $offer_id;
        $dealdata->product_id = $product_id;
        $dealdata->save();

        $data = array();
        if($dealdata){
            $product = Product::where('id',$product_id)->select('name','image','brand_id','price')->first();
            $product->rating = ProductRating::totalRating($product_id);
            $prodLikeStatus = '0';
            if ($user) {
                $prodLikeStatus = product_like($product_id,$user->id);
            }
            $product->like_status = $prodLikeStatus;


            $offer = Offer::where('id', $offer_id)->first();
            $brand = Brand::where('id',$product->brand_id)->select('id','name','icon','banner_image')->first();
            $brand->rating = brand_rating($product->brand_id);
            $branch = Branch::where('id', $branch->id)->first();
            $userdata = User::where('id',$user->id)->first();


            $data['product'] = $product;
            $data['offer'] = $offer;
            $data['brand'] = $brand;
            $data['location'] = $branch;
            $data['user'] = $userdata;
        }else{
            return sendError(array(), 'Redeem error'); 
        }
        
        return sendResponse($data, 'Redeem successfully.');
        
    }

    public function active_deal(Request $request)
    {
        $user = Auth::guard('api')->user();
        $today = Carbon::today()->toDateString();

        $deals = UserDeal::with(['offer', 'branch'])
            ->where('user_id', $user->id)
            ->whereHas('offer', function ($q) use ($today) {
                    $q->whereDate('end_date', '>=', $today)  // ✅ Only active offers
                    ->where('status', '1');
            })
            ->orderByDesc('id') 
            ->get();

         foreach ($deals as &$prod) {
            $proddata = Product::where('id',$prod['product_id'])->select('name','image','brand_id','price','veg_nonveg')->first();
            $proddata['rating'] = ProductRating::totalRating($prod['product_id']);
            
            $prodLikeStatus = '0';
            if ($user) {
                $prodLikeStatus = product_like($prod['product_id'],$user->id);
            }
            $proddata['like_status'] = $prodLikeStatus;
            $proddata['deal_count'] = deal_count($prod['product_id']);
            
            $brand_datas = Brand::where('id',$proddata->brand_id)->select('icon')->first();
            $proddata['brand_image'] = asset('uploads/brand/' . $brand_datas->icon);


            $discount = 0;
            if ($prod['offer']->discount_type === 'percentage') {
                $discount = (float) $prod['offer']->discount_value;
            } elseif ($prod['offer']->discount_type === 'fixed') {
                $discount = $proddata->price > 0
                    ? round(($prod['offer']->discount_value / $proddata->price) * 100, 2)
                    : 0;
            }
            
            $proddata['discount_amount'] = $discount > 0 ? "{$discount}%" : '';

            $proddata['count'] = ProductView::totalCount($prod['product_id']);
            $proddata['veg'] = $proddata->veg_nonveg;
            unset($proddata['veg_nonveg']);
            $prod['product'] = $proddata;
        }

         return sendResponse($deals, 'Data fetch successfully.');   
       
    }

    public function expired_deal(Request $request)
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
        $today = Carbon::today()->toDateString();
        $page = (int)$request->page ?? 1;
        $limit = $request->input('limit', env('PAGINATION_LIMIT', 10));

        // ✅ Fetch all expired deals first
        $allDeals = UserDeal::with(['offer', 'branch'])
            ->where('user_id', $user->id)
            ->whereHas('offer', function ($q) use ($today) {
                $q->whereDate('end_date', '<=', $today)
                ->where('status', '1');
            })
            ->orderByDesc('id')
            ->get();

        // ✅ Format data
        $deals = [];
        foreach ($allDeals as $prod) {
            $proddata = Product::where('id', $prod->product_id)
                ->select('id', 'name', 'image', 'brand_id', 'price')
                ->first();

            if (!$proddata) continue;

            $proddata->rating = ProductRating::totalRating($prod->product_id);

            $prodLikeStatus = $user ? product_like($prod->product_id, $user->id) : '0';
            $proddata->like_status = $prodLikeStatus;
            $proddata->deal_count = deal_count($prod->product_id);

            $brand_data = Brand::where('id', $proddata->brand_id)->select('icon')->first();
            $proddata->brand_image = $brand_data ? asset('uploads/brand/' . $brand_data->icon) : '';

            // ✅ Calculate discount percentage
            $discount = 0;
            if ($prod->offer->discount_type === 'percentage') {
                $discount = (float) $prod->offer->discount_value;
            } elseif ($prod->offer->discount_type === 'fixed') {
                $discount = $proddata->price > 0
                    ? round(($prod->offer->discount_value / $proddata->price) * 100, 2)
                    : 0;
            }

            $proddata->discount_amount = $discount > 0 ? "{$discount}%" : '';

            $deals[] = [
                'id' => $prod->id,
                'branch' => $prod->branch,
                'offer' => $prod->offer,
                'product' => $proddata,
            ];
        }

        // ✅ Manual pagination
        $totalItems = count($deals);
        $totalPage = ceil($totalItems / $limit);
        $start = ($page - 1) * $limit;
        $paginatedDeals = array_slice($deals, $start, $limit);

        $is_nextpage = $page < $totalPage ? '1' : '0';

        return sendResponsePagination($paginatedDeals, 'Data fetched successfully.', $is_nextpage);
    }


    public function favorite(Request $request)
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
        $userdata = User::where('id',$user->id)->first();

        $user_lat = $userdata->latitude;
        $user_long = $userdata->longitude;
        $page = $request->page;
        $limit = 4;
        $start = ($page-1) * $limit;
        
        $ulike = UserLike::join('products', 'user_likes.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereNull('user_likes.brand_id')
            ->whereNull('user_likes.branch_id')
            ->where('categories.is_fashion','!=','1')
            ->where('user_likes.user_id',$user->id)
            ->where('user_likes.status','1')
            ->select('user_likes.product_id')
            ->orderBy('user_likes.id', 'desc');


        $all_data = $ulike->get();
        $paginationdata = $ulike->skip($start)->take($limit)->get();

        foreach($paginationdata as $val){
            $proddata = Product::where('id', $val->product_id)
                ->select('id', 'name', 'image', 'brand_id', 'price','veg_nonveg')
                ->first();
            $proddata->rating = ProductRating::totalRating($val->product_id);

            $prodLikeStatus = $user ? product_like($val->product_id, $user->id) : '0';
            $proddata->like_status = $prodLikeStatus;

            $brand_data = Brand::where('id', $proddata->brand_id)->select('icon')->first();
            $proddata->brand_image = $brand_data ? asset('uploads/brand/' . $brand_data->icon) : '';
            
            $discount = getProductDiscountPercentage($val->product_id);
            $proddata->discount_amount = $discount > 0 ? "{$discount}%" : '';
            $proddata->veg = $proddata->veg_nonveg;
            $proddata->count = ProductView::totalCount($val->product_id);


             $offer = Offer::where('product_id', $val->product_id)->where('status', '1')
                                ->whereDate('start_date', '<=', now())
                                ->whereDate('end_date', '>=', now())
                                ->orderByDesc('id')
                                ->first();
            $branch = getNearestBranch($proddata->brand_id, $user_lat, $user_long);

            unset($proddata->veg_nonveg);

            $val['product'] = $proddata;
            $val['offer'] = $offer ?? (object) [];
            $val['location'] = $branch ?? (object) [];
             
        }
            

        $count = count($all_data);
        $total_page = ceil($count/$limit);
        if ($total_page > $page) {
            $is_nextpage = '1';
        }else{
            $is_nextpage = '0';
        }

        $branlike = UserLike::whereNull('user_likes.product_id')
            ->where('user_likes.user_id',$user->id)
            ->whereNull('user_likes.product_id')
            ->whereNull('user_likes.branch_id')
            ->where('user_likes.status','1')
            ->select('user_likes.brand_id')
            ->orderBy('user_likes.id', 'desc')
            ->get();

        foreach($branlike as $vals){
            $branddata = Brand::join('categories', 'brands.category_id', '=', 'categories.id')
                ->where('brands.id', $vals->brand_id)
                ->select('brands.id','brands.category_id', 'brands.name', 'brands.icon','categories.is_fashion')
                ->first();
            $likestatus = '0';
            if ($user) {
                $likestatus = brand_like($vals->brand_id,$user->id);
            }


            $totbranddiscount = getBrandTotalDiscountPercentage($vals->brand_id);
            if($totbranddiscount  <= '0'){
                    $tot_brand_discount = '';
            }else{
                    $tot_brand_discount = (string) $totbranddiscount.'%';
            }

            $branddata->discount_amount = $tot_brand_discount;
            $branddata->like_status = $likestatus;
            $branddata->count = BrandView::totalCount($vals->brand_id);


            $vals['brand'] = $branddata; 
        }


         $data['brand'] =  $branlike; 
         $data['product'] =  $paginationdata; 

    
        return sendResponsePagination($data, 'Favourite List Fetch Successfully.',$is_nextpage); 
            
    }

     public function fashion_favorite(Request $request)
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
        $userdata = User::where('id',$user->id)->first();

        $user_lat = $userdata->latitude;
        $user_long = $userdata->longitude;
        $page = $request->page;
        $limit = 4;
        $start = ($page-1) * $limit;
        
        $ulike = UserLike::join('products', 'user_likes.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereNull('user_likes.brand_id')
            ->whereNull('user_likes.branch_id')
            ->where('categories.is_fashion','1')
            ->where('user_likes.user_id',$user->id)
            ->where('user_likes.status','1')
            ->select('user_likes.product_id')
            ->orderBy('user_likes.id', 'desc');


        $all_data = $ulike->get();
        $paginationdata = $ulike->skip($start)->take($limit)->get();

        foreach($paginationdata as $val){
            $proddata = Product::where('id', $val->product_id)
                ->select('id', 'name', 'image', 'brand_id', 'price')
                ->first();
            $proddata->rating = ProductRating::totalRating($val->product_id);

            $prodLikeStatus = $user ? product_like($val->product_id, $user->id) : '0';
            $proddata->like_status = $prodLikeStatus;

            $brand_data = Brand::where('id', $proddata->brand_id)->select('name','icon')->first();
            $proddata->brand_name = $brand_data->name;
            $proddata->brand_image = $brand_data ? asset('uploads/brand/' . $brand_data->icon) : '';
            
            $discount = getProductDiscountPercentage($val->product_id);
            $proddata->discount_amount = $discount > 0 ? "{$discount}%" : '';
            $proddata->deal_count = fashion_deal_count($val->product_id);
            
            $proddata->view_count = ProductView::totalCount($val->product_id);


             $offer = Offer::where('product_id', $val->product_id)->where('status', '1')
                                ->whereDate('start_date', '<=', now())
                                ->whereDate('end_date', '>=', now())
                                ->orderByDesc('id')
                                ->first();
            $newprice = 0;                    
            if($offer){
                if($offer->discount_type == 'fixed'){
                         $newprice = $proddata->price - $offer->discount_value;
                }else{
                    $discount_val = ($proddata->price*$offer->discount_value)/100;
                    $newprice = $proddata->price - $discount_val;
                }
                $branch = getNearestOfferBranch($offer->id, $user_lat, $user_long);
            }else{
                $branch = getNearestBranch($proddata->brand_id, $user_lat, $user_long);
            }   

            if($newprice == 0){
                $proddata->old_price = "0";
                $proddata->price = $proddata->price;
            }else{
                $proddata->old_price = $proddata->price;
                $proddata->price = $newprice;
            }
            
            


            

            $val['product'] = $proddata;
            $val['offer'] = $offer ?? (object) [];
            $val['location'] = $branch ?? (object) [];
             
        }
            

        $count = count($all_data);
        $total_page = ceil($count/$limit);
        if ($total_page > $page) {
            $is_nextpage = '1';
        }else{
            $is_nextpage = '0';
        }

        return sendResponsePagination($paginationdata, 'Favourite List Fetch Successfully.',$is_nextpage); 
            
    }


}