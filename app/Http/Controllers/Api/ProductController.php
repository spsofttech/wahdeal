<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\Offer;
use App\Models\BrandView;
use App\Models\BrandTiming;
use App\Models\BrandMenu;
use App\Models\ShortLink;
use App\Models\ProductView;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $rules = [
            'latitude' => 'required',
            'longitude' => 'required',
            'category' => 'required',
            'page' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();

        $category_id = $request->category;
        $brand_id = $request->brand;
        $subcategory_id = $request->subcategory;
        $user_lat = $request->latitude;
        $user_long = $request->longitude;
        $search_discount = $request->discount;
        $page = $request->page;
        $limit = env('PAGINATION_LIMIT', 10);

        // ✅ Fetch category, subcategories, and brands
        $category = Category::with([
            'subcategories' => function ($q) {
                $q->where('status', '1')->orderBy('id', 'asc');
            },
            'brands' => function ($q) {
                $q->where('status', '1')->orderBy('id', 'desc');
            }
        ])
        ->where('id', $category_id)
        ->where('status', '1')
        ->first();

        if (!$category) {
            return sendError([], 'Category not found.');
        }

        // ✅ Map category with filtered brands (if subcategory passed)
        $categoryData = [
            'category_id' => $category->id,
            'category_name' => $category->name,
            'subcategory_count' => $category->subcategories->count(),
            'brand_count' => $category->brands->count(),
            'subcategories' => $category->subcategories->map(function ($sub) {
                return [
                    'subcategory_id' => $sub->id,
                    'subcategory_name' => $sub->name,
                    'icon' => $sub->image_url ?? '',
                    'brands_count' => $sub->brands()->where('status', '1')->count(),
                ];
            }),
            'brands' => $category->brands
                ->filter(function ($brand) use ($subcategory_id) {
                    if (!empty($subcategory_id)) {
                        // Only include brands under this subcategory
                        return $brand->subcategory_id == $subcategory_id;
                    }
                    return true;
                })
                ->map(function ($brand) use ($user_lat, $user_long) {
                    $pro_near_location = getNearestBranch($brand->id, $user_lat, $user_long);
                    $location = $pro_near_location ?: (object) [];

                    $rating = brand_rating($brand->id);

                    return [
                        'id' => $brand->id,
                        'subcategory_id' => $brand->subcategory_id,
                        'name' => $brand->name,
                        'description' => $brand->description,
                        'icon' => $brand->image_url ?? '',
                        'location' => $location,
                        'rating' => $rating,
                        'count' => BrandView::totalCount($brand->id)
                    ];
                })
                ->values(), // reset keys
        ];

        
        $discount_per = getBrandDiscountPercentage($brand_id);
        $products = getProductsOnly($category_id, $brand_id, $subcategory_id, $user_lat, $user_long, $search_discount, $page, $limit);

        if (!empty($products['products'])) {
            foreach ($products['products'] as &$val) {
                $brand = Brand::find($val['brand_id']);
                $prodLikeStatus = '0';

                if ($user) {
                    $prodLikeStatus = product_like($val['id'], $user->id);
                }

                $val['veg'] = $val['veg_nonveg'];
                $val['like_status'] = $prodLikeStatus;
                $val['brand_image'] = $brand ? asset('uploads/brand/' . $brand->icon) : '';
                $val['deal_count'] = deal_count($val['id']);
                $val['count'] = ProductView::totalCount($val['id']);
            }
        }

        $is_nextpage = $products['is_nextpage'];

        $data['discount_per'] = $discount_per;
        $data['category'] = $categoryData;
        $data['product'] = $products['products'];

        if($user){
            $data['is_blur'] = is_blur($user->id);
        }else{
            $data['is_blur'] = '0';
        }

        return sendResponsePagination($data, 'Category List Fetch Successfully.', $is_nextpage);
    }

    public function product(Request $request)
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
      

        if($request->latitude){
            $user_lat    = $request->latitude;
            $user_long   = $request->longitude;
        }else{
            $userlatitude = getstaticlatlong();
            $user_lat = $userlatitude['lat'];
            $user_long = $userlatitude['long'];
        }


        
        $product = Product::where('id',$id)->first();

        if(!$product){
            return sendError(array(), 'Product not exists'); 
        }

        $offer = Offer::where('product_id', $id)->where('status', '1')
                                ->whereDate('start_date', '<=', now())
                                ->whereDate('end_date', '>=', now())
                                ->orderByDesc('id')
                                ->first();

        $review = ProductRating::with('user:id,first_name,last_name,image')
                ->where('product_id', $id)
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

        $product->veg = $product->veg_nonveg;
        $product->offer = $offer ?? (object)[];
        $product->rating  = ProductRating::totalRating($id);
        $product->deal_count = deal_count($id);
        $product->count = ProductView::totalCount($id);
        $product->review = $review ?? array();
        $product->gallery = getProductImages($id);

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

                $val['like_status'] = $prodLikeStatus;
                $val['deal_count'] = deal_count($val['id']);
                $val['rating'] = ProductRating::totalRating($val['id']);
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

                $pro_near_location2 = getNearestBranch($vals['brand_id'], $user_lat, $user_long);
                if($pro_near_location2){
                    $vals['location'] = $pro_near_location2;
                }else{
                    $vals['location'] = (object) [];
                }

                $vals['like_status'] = $prodLikeStatus;
                $vals['deal_count'] = deal_count($vals['id']);
                $vals['rating'] = ProductRating::totalRating($vals['id']);
                $vals['brand_image'] = $branddata ? asset('uploads/brand/' . $branddata->icon) : '';
            }
        }


        $product->similar_product = $similarProducts ?? array();
        $product->other_product = $OtherProducts ?? array();




        $brand = Brand::where('id',$product->brand_id)->select('id','name','icon','description','banner_image')->first();
        $branch = getNearestBranch($product->brand_id, $user_lat, $user_long);
        $brand->location = $branch ?? (object) [];
        $brand->rating = brand_rating($product->brand_id);
        $brand->count =  BrandView::totalCount($product->brand_id);
        
       

        if($branch){
            $brand->timing = BrandTiming::where('branch_id',$branch->id)->where('brand_id',$product->brand_id)->where('status','1')->get();
            $brand->menu = branchmenu($branch->id);
        }else{
            $brand->timing = array();
            $brand->menu = brandmenu($product->brand_id);
        }

        
        $rating_exists = '0';
        if($user){
            $ratingexists = ProductRating::where('product_id',$product->id)->where('user_id',$user->id)->first();
            if($ratingexists){
                $rating_exists = '1';
            }




            $existsproductview = ProductView::where('product_id',$product->id)->where('user_id',$user->id)->first();
            if(!$existsproductview){
                $pviewdata = array(
                            "product_id"=>$product->id,
                            "user_id"=>$user->id,
                        );
                        ProductView::create($pviewdata);
            }

            $brandviewexists = BrandView::where('brand_id',$product->brand_id)->where('user_id',$user->id)->first();
            if(!$brandviewexists){
                $brandviewdata = array(
                            "brand_id"=>$product->brand_id,
                            "user_id"=>$user->id,
                        );

                BrandView::create($brandviewdata);
            }


        }
        $product->rating_exists = $rating_exists;

        $b_link = ShortLink::where('type','brand')->where('item_id',$product->brand_id)->first();
        $p_link = ShortLink::whereIn('type', ['product', 'shoping_product'])->where('item_id',$product->id)->first();

        $data['product'] = $product;
        $data['brand'] = $brand;
        $data['payment_text'] = 'Cash,Debit Card,E-Wallet';
        $data['brand_website'] = url("/d/{$b_link->code}/{$product->brand_id}/brand");
        $data['product_website'] = url("/d/{$p_link->code}/{$product->id}/product");

        if($user){
            $data['is_blur'] = is_blur($user->id);
        }else{
            $data['is_blur'] = '0';
        }
        

        return sendResponse($data, 'Data fetch successfully.');
    }


    public function add_rating(Request $request)
    {
        $rules = [
            'id' => 'required',
            'rating' => 'required',
            'review' => 'required',
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

        $product = Product::where('id',$request->id)->first();

        if(!$product){
            return sendError(array(), 'Product not exists'); 
        }

        $existspr = ProductRating::where('user_id',$user->id)->where('product_id',$request->id)->first();
        if($existspr){
            return sendError(array(), 'Product rating already added'); 
        }

        $rating = ProductRating::create([
            'product_id' => $request->id,
            'user_id' => $user->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);
       
        return sendResponse($rating, 'Review added successfully.');
        
    }

    public function edit_rating(Request $request)
    {
        $rules = [
            'id' => 'required',
            'rating' => 'required',
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


        $rating = ProductRating::where('user_id',$user->id)->where('id',$request->id)->first();
        if(!$rating){
            return sendError(array(), 'Product rating not exists'); 
        }

        $rating->rating = $request->rating;
        $rating->review = $request->review;
        $rating->save();
       
        return sendResponse($rating, 'Review updated successfully.');
        
    }

     public function delete_rating(Request $request)
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


        $rating = ProductRating::where('user_id',$user->id)->where('id',$request->id)->first();
        if(!$rating){
            return sendError(array(), 'Product rating not exists'); 
        }

        $rating->delete();
       
        return sendResponse(array(), 'Review deleted successfully.');
        
    }

}