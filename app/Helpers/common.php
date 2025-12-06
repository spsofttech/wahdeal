<?php
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\BrandBanner;
use App\Models\Brand;
use App\Models\Branch;
use App\Models\UserLike;
use App\Models\ProductRating;
use App\Models\ShortLink;
use App\Models\UserDeal;
use App\Models\ProductImage;
use App\Models\BrandMenu;
use App\Models\FashionOfferBanner;
use App\Models\ProductView;
use App\Models\UserAddress;
use App\Models\Cart;
use App\Models\Offer;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\CouponCode;
use App\Models\UserCouponCode;
use App\Models\ProductSizeColorPrice;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\BrandGallery;
use App\Models\Role;
use App\Models\BranchChangeRequest;
use Illuminate\Support\Facades\Auth;


function sendResponse($result, $message)
{
   
    $response['status'] = 1; 
    $response['data'] = $result; 
    $response['message'] = $message;
    return response()->json($response, 200);
}

function sendError($result,$message)
{
    $response = [
        'status' => 0,
        'data' => (object)$result,
        'message' => $message,
    ];
    return response()->json($response, 200);
}

function sendResponsePagination($result, $message, $offset)
{

    $response['status'] = 1; 
    $response['data'] = $result; 
    $response['next_page'] =  $offset;
    $response['message'] = $message;
    return response()->json($response, 200);
}

function generatePromoCode($length = 5) {
    $characters = '0123456789';
    $prefix = 'WAH';
    
    do {
        $promoCode = $prefix;
        for ($i = 0; $i < $length; $i++) {
            $promoCode .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        // Check if promo code already exists
        $exists = User::where('promo_code', $promoCode)->exists();
    } while ($exists); // repeat if already exists

    return $promoCode;
}


function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function uploadBase64File($base64Data, $destinationFolder) {
    if (preg_match('/^data:.+?;base64,/', $base64Data)) {
        $base64Data = preg_replace('/^data:.+?;base64,/', '', $base64Data);
    }
    $fileData = base64_decode($base64Data);

   

    if ($fileData === false) {
        return ['status' => 'error', 'message' => 'Failed to decode base64 data'];
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE); // Return MIME type
    $mimeType = finfo_buffer($finfo, $fileData); // Get MIME type from the file data
    finfo_close($finfo);

   
    $mimeTypeToExtension = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'audio/mp3' => 'mp3',
        'audio/wav' => 'wav',
        'audio/ogg' => 'ogg',
        'audio/mpeg' => 'mpeg',
        'video/mp4' => 'mp4',
        'application/pdf' => 'pdf',
        'application/vnd.ms-excel' => '.xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => '.xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.macroEnabled.12' => '.xlsm',
        'application/vnd.ms-excel.sheet.binary.macroEnabled.12' => '.xlsb',
        'application/vnd.ms-excel.template.macroEnabled.12' => '.xlt',
        'application/vnd.ms-excel.template.macroEnabled.12' => '.xltm',
   ];

   $filetype =  $mimeTypeToExtension[$mimeType];


    $fileName = 'upload_' . time() . rand() . '.'.$filetype;
    $filePath = rtrim($destinationFolder, '/') . '/' . $fileName;
    file_put_contents($filePath, $fileData);
    return  $fileName;

}

function get_user_profile($id){
    $userdata = User::with('addresses')->where('id', $id)->first();
    return $userdata;
}



function home_data($categoryId = null, $page = 1, $limit = 2, $userLat = null, $userLng = null, $search = null)
{
    $today = Carbon::today()->toDateString();
    $start = ($page - 1) * $limit;

    // Load categories, subcategories, brands, products, offers, branches
    $categoriesQuery = Category::with([
        'subcategories' => function ($q) {
            $q->where('status', '1')
              ->select('id', 'category_id', 'name', 'rank')
              ->orderBy('rank', 'asc');
        },
        'brands' => function ($q) use ($today) {
            $q->where('status', '1')
              ->select('id', 'category_id', 'subcategory_id', 'name', 'icon', 'description','veg_nonveg')
              ->with([
                  'products' => function ($pq) use ($today) {
                      $pq->select('id', 'brand_id', 'category_id', 'subcategory_id', 'price', 'name', 'image')
                         ->with(['offer' => fn($oq) => $oq->where('status', '1')
                                                            ->whereDate('start_date', '<=', $today)
                                                            ->whereDate('end_date', '>=', $today)]);
                  },
                  'branches:id,brand_id,latitude,longitude,city,state'
              ]);
        }
    ])
    ->where('status', '1')
    ->when($categoryId, fn($q) => $q->where('id', $categoryId))
    ->select('id', 'name', 'icon', 'rank', 'status')
    ->orderBy('rank', 'asc');

    $all_data = $categoriesQuery->get();
    

    // Compute discount and nearest branch
    $computeBrandDiscount = function ($brand) {
        $maxDiscount = 0;
        foreach ($brand->products as $product) {
            $offer = $product->offer ?? null;
            $discount = 0;
            if ($offer) {
                $discount = $offer->discount_type === 'percentage'
                    ? (float) $offer->discount_value
                    : ($product->price > 0
                        ? round(($offer->discount_value / $product->price) * 100, 2)
                        : 0);
            }
            $product->discount_amount = (string) $discount;
            $maxDiscount = max($maxDiscount, $discount);
        }
        $brand->max_discount = (string) $maxDiscount;
        return $brand;
    };

    $computeNearestBranch = function ($brand, $userLat, $userLng) {
        if (empty($userLat) || empty($userLng) || $brand->branches->isEmpty()) {
            $brand->nearest_branch = null;
            $brand->distance_km = null;
            return $brand;
        }
        $nearestBranch = null;
        $minDistance = PHP_FLOAT_MAX;
        foreach ($brand->branches as $branch) {
            $distance = haversineDistance($userLat, $userLng, $branch->latitude, $branch->longitude);
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearestBranch = $branch;
            }
        }
        $brand->nearest_branch = $nearestBranch;
        $brand->distance_km = round($minDistance, 2);
        return $brand;
    };

    // Process categories
    $categories = $all_data->map(function ($category) use ($computeBrandDiscount, $computeNearestBranch, $userLat, $userLng) {
        $subcategories = $category->subcategories ?? collect();
        $subIds = $subcategories->pluck('id')->toArray();

        $subcategoryBrandsMap = [];
        $noSubBrands = collect();

        foreach ($category->brands as $brand) {
            $brand = $computeBrandDiscount($brand);
            $brand = $computeNearestBranch($brand, $userLat, $userLng);
            if ($brand->subcategory_id && in_array($brand->subcategory_id, $subIds)) {
                $subcategoryBrandsMap[$brand->subcategory_id][] = $brand;
            } else {
                $noSubBrands->push($brand);
            }
        }

        // Attach brands/products to subcategories
        $category->subcategories = $subcategories->map(function ($sub) use ($subcategoryBrandsMap) {
            $brands = isset($subcategoryBrandsMap[$sub->id])
                ? collect($subcategoryBrandsMap[$sub->id])
                : collect();

            $products = collect();
            foreach ($brands as $brand) {
                foreach ($brand->products as $product) {
                    $products->push($product);
                }
            }

            $sub->brands = $brands->values();
            $sub->products = $products->values();
            $sub->max_discount = (string) ($brands->max('max_discount') ?? 0);
            $sub->marketing_banner = [];
            $sub->poster_banner = [];
            $sub->square_banner = [];

            return $sub;
        })->sortBy('rank')->values();

        // Brands without subcategory
        if ($noSubBrands->count() > 0) {
            $noSubProducts = collect();
            foreach ($noSubBrands as $brand) {
                foreach ($brand->products as $product) {
                    $noSubProducts->push($product);
                }
            }

            $category->subcategories->push((object)[
                'subcategory_id' => 0,
                'subcategory_name' => '',
                'brands' => $noSubBrands->values(),
                'products' => $noSubProducts->values(),
                'max_discount' => (string) ($noSubBrands->max('max_discount') ?? 0),
                'marketing_banner' => [],
                'poster_banner' => [],
                'square_banner' => []
            ]);
        }

        return $category;
    });

    // --- SEARCH: bubble matching items first ---
    if (!empty($search)) {
        $categories = $categories->map(function ($category) use ($search) {
            $category->matches_search = stripos($category->name, $search) !== false;

            $category->subcategories = $category->subcategories->map(function ($sub) use ($search) {
                $sub->matches_search = stripos($sub->name ?? '', $search) !== false;

                $sub->brands = $sub->brands->map(function ($brand) use ($search) {
                    $brand->matches_search = stripos($brand->name, $search) !== false;

                    $brand->products = $brand->products->map(function ($product) use ($search) {
                        $product->matches_search = stripos($product->name, $search) !== false;
                        return $product;
                    })->values();

                    if ($brand->products->where('matches_search', true)->isNotEmpty()) {
                        $brand->matches_search = true;
                    }
                    return $brand;
                })->values();

                if ($sub->brands->where('matches_search', true)->isNotEmpty()) {
                    $sub->matches_search = true;
                }

                return $sub;
            })->values();

            if ($category->subcategories->where('matches_search', true)->isNotEmpty()) {
                $category->matches_search = true;
            }

            return $category;
        });

        // Bubble matching items
        $categories = $categories->sortByDesc(fn($cat) => $cat->matches_search ? 1 : 0)->values();
        $categories = $categories->map(function ($category) {
            $category->subcategories = $category->subcategories
                ->sortByDesc(fn($sub) => $sub->matches_search ? 1 : 0)
                ->values();

            $category->subcategories = $category->subcategories->map(function ($sub) {
                $sub->brands = $sub->brands
                    ->sortByDesc(fn($brand) => $brand->matches_search ? 1 : 0)
                    ->values();

                $sub->brands = $sub->brands->map(function ($brand) {
                    $brand->products = $brand->products
                        ->sortByDesc(fn($product) => $product->matches_search ? 1 : 0)
                        ->values();
                    return $brand;
                });

                return $sub;
            });

            return $category;
        });
    }

    // --- REMOVE EMPTY SUBCATEGORIES & CATEGORIES ---
    $categories = $categories->map(function ($category) {
        $category->subcategories = $category->subcategories
            ->filter(fn($sub) => $sub->products->isNotEmpty())
            ->values();
        return $category;
    });

    $categories = $categories
        ->filter(fn($cat) => $cat->subcategories->isNotEmpty())
        ->values();

    // --- Pagination slice ---
    $total_count = $categories->count();
    $categories = $categories->slice($start, $limit)->values();
    $is_nextpage = $total_count > ($page * $limit) ? '1' : '0';

    return [
        'categories' => $categories,
        'all_data' => $all_data,
        'is_nextpage' => $is_nextpage
    ];
}




function offer_data($categoryId = null,$page = 1,$limit = 2,$userLat = null,$userLng = null,$search = null,$offerType = null,$minDiscount = null, $minRating = null) {
    $today = Carbon::today()->toDateString();
    $start = ($page - 1) * $limit;

    // --- Fetch Categories ---
    $categoriesQuery = DB::table('categories')
        ->where('status', '1')
        ->when($categoryId, fn($q) => $q->where('id', $categoryId))
        ->when($search, fn($q) => $q->where('name', 'LIKE', "%{$search}%"))
        ->orderBy('rank', 'asc')
        ->get();

    $categories = [];

    foreach ($categoriesQuery as $category) {

        // --- Fetch Subcategories ---
        $subcategories = DB::table('subcategories')
            ->where('category_id', $category->id)
            ->where('status', '1')
            ->orderBy('rank', 'asc')
            ->get();

        // --- Fetch Brands ---
        $brandsQuery = DB::table('brands')
            ->where('category_id', $category->id)
            ->where('status', '1')
            ->when($search, fn($q) => $q->where('name', 'LIKE', "%{$search}%"))
            ->get();

        $subcategoryBrandsMap = [];
        $noSubBrands = [];

        foreach ($brandsQuery as $brand) {
            

            // --- Fetch Products ---
            $productsQuery = DB::table('products')
                ->where('brand_id', $brand->id)
                ->where('status', '1')
                ->when($search, fn($q) => $q->where('name', 'LIKE', "%{$search}%"))
                ->get();

            $products = [];
            foreach ($productsQuery as $product) {
                // --- Fetch active offer ---
                $offer = DB::table('offers')
                    ->where('product_id', $product->id)
                    ->where('status', '1')
                    ->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today)
                    ->when($offerType, fn($q) => $q->where('offer_type', $offerType))
                    ->first();

                if ($offer) {
                    // Compute discount %
                    if ($offer->discount_type == 'percentage') {
                        $product->discount_amount = $offer->discount_value;
                    } else {
                        $product->discount_amount = $product->price > 0
                            ? round(($offer->discount_value / $product->price) * 100, 2)
                            : 0;
                    }

                    $product->offer = $offer;
                    $products[] = $product;
                }
            }

            if (empty($products)) continue;

            // --- Compute max discount for brand ---
            $brand->max_discount = !empty($products)
                ? round(max(array_column($products, 'discount_amount')), 2)
                : 0;

            // --- Compute rating ---
            $ratings = DB::table('product_ratings')
                ->whereIn('product_id', array_column($products, 'id'))
                ->pluck('rating')
                ->toArray();
            $brand->avg_rating = !empty($ratings) ? round(array_sum($ratings)/count($ratings), 1) : 0;

            // --- Apply filters ---
            if ($minDiscount && $brand->max_discount < $minDiscount) continue;
            if ($minRating && $brand->avg_rating < $minRating) continue;

            // --- Assign products to brand ---
            $brand->products = $products;

            if ($brand->subcategory_id) {
                $subcategoryBrandsMap[$brand->subcategory_id][] = $brand;
            } else {
                $noSubBrands[] = $brand;
            }
        }

        // --- Map Subcategories with brands & products ---
        $categorySubs = [];
        foreach ($subcategories as $sub) {
            $brands = $subcategoryBrandsMap[$sub->id] ?? [];
            $subProducts = [];
            foreach ($brands as $b) {
                $subProducts = array_merge($subProducts, $b->products);
            }

            if (!empty($subProducts)) {
                $sub->brands = $brands;
                $sub->products = $subProducts;
                $sub->max_discount = !empty($brands) ? max(array_column($brands, 'max_discount')) : 0;
                $categorySubs[] = $sub;
            }
        }

        // --- Brands without subcategory ---
        if (!empty($noSubBrands)) {
            $noSubProducts = [];
            foreach ($noSubBrands as $b) {
                $noSubProducts = array_merge($noSubProducts, $b->products);
            }

            if (!empty($noSubProducts)) {
                $categorySubs[] = (object)[
                    'subcategory_id' => 0,
                    'subcategory_name' => '',
                    'brands' => $noSubBrands,
                    'products' => $noSubProducts,
                    'max_discount' => !empty($noSubBrands) ? max(array_column($noSubBrands, 'max_discount')) : 0,
                ];
            }
        }

        if (!empty($categorySubs)) {
            $category->subcategories = $categorySubs;
            $categories[] = $category;
        }
    }

    // --- Pagination ---
    $total_count = count($categories);
    $categories = array_slice($categories, $start, $limit);
    $is_nextpage = $total_count > ($page * $limit) ? '1' : '0';

    return [
        'categories' => $categories,
        'is_nextpage' => $is_nextpage,
        'all_data' => [],
    ];
}




function haversineDistance($lat1, $lon1, $lat2, $lon2)
{
    // Convert to numeric or default to 0
    $lat1 = floatval($lat1);
    $lon1 = floatval($lon1);
    $lat2 = floatval($lat2);
    $lon2 = floatval($lon2);

    // If any value is missing, return 0
    if (!$lat1 || !$lon1 || !$lat2 || !$lon2) {
        return 0;
    }

    $earthRadius = 6371; // km

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) ** 2 +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon / 2) ** 2;

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $earthRadius * $c;
}


function getMaxDiscountProduct($brandId)
{
    $today = Carbon::today();

    $products = Product::with(['offer' => function ($q) use ($today) {
            $q->where('status', '1')
              ->whereDate('start_date', '<=', $today)
              ->whereDate('end_date', '>=', $today);
        }])
        ->where('brand_id', $brandId)
        ->whereHas('offer', function ($q) use ($today) {
            $q->where('status', '1')
              ->whereDate('start_date', '<=', $today)
              ->whereDate('end_date', '>=', $today);
        })
        ->select('products.id','products.brand_id','products.name','products.price','products.image','products.veg_nonveg','brands.icon')
        ->addSelect(DB::raw("
            CASE 
                WHEN offers.discount_type = 'percent' THEN (products.price * offers.discount_value / 100) 
                ELSE offers.discount_value 
            END as discount_amount
        "))
        ->join('offers', 'offers.product_id', '=', 'products.id')
        ->join('brands', 'brands.id', '=', 'products.brand_id')
        ->groupBy('products.id')
        ->orderByDesc('discount_amount')
        ->get();

    // Convert to array with desired fields
    return $products->map(function($product){
        return [
            'id' => $product->id,
            'brand_id' => $product->brand_id,
            'brand_image' => $product->icon,
            'name' => $product->name,
            'price' => $product->price,
            'image_url' => $product->image ? asset('uploads/product/'.$product->image) : null,
            'discount_amount' => $product->discount_amount,
            'offer' => $product->offer ?? null,
            'veg' => $product->veg_nonveg ?? 1
        ];
    })->toArray();
}

function getProductsOnly($categoryId = null, $brandId = null, $subcategoryId = null, $userLat = null, $userLng = null, $discountFilter = null, $page = 1, $limit = 10)
{
    $today = Carbon::today()->toDateString();

    $productsQuery = Product::with([
        'offer' => fn($q) => $q->where('status', '1')
                                ->whereDate('start_date', '<=', $today)
                                ->whereDate('end_date', '>=', $today)
    ])->where('status', '1');

    if ($categoryId) $productsQuery->where('category_id', $categoryId);
    if ($brandId) $productsQuery->where('brand_id', $brandId);
    if ($subcategoryId) $productsQuery->where('subcategory_id', $subcategoryId);

    // ✅ Fetch all first (no pagination here)
    $products = $productsQuery->get();
    $total_count = $products->count();

    // Calculate discount, rating, location, etc.
    $products = $products->map(function ($product) use ($userLat, $userLng) {
        $discount = 0;

        if (isset($product->offer->discount_type)) {
            if ($product->offer->discount_type === 'percentage') {
                $discount = (float) $product->offer->discount_value;
            } elseif ($product->offer->discount_type === 'fixed' && $product->price > 0) {
                $discount = round(($product->offer->discount_value / $product->price) * 100, 2);
            }
        }

        $product->discount_amount = $discount > 0 ? "{$discount}%" : '';

        if (!empty($userLat) && !empty($userLng)) {
            $nearestBranch = getNearestBranch($product->brand_id, $userLat, $userLng);
            $product->location = $nearestBranch ?: (object)[];
        } else {
            $product->location = (object)[];
        }

        $product->rating = ProductRating::totalRating($product->id);
        $product->offers = $product->offer ?? (object)[];
        unset($product->offer);

        return $product;
    });

    // ✅ Filter by discount percentage if given
    if ($discountFilter) {
        $products = $products->filter(function ($p) use ($discountFilter) {
            $discountValue = (float) str_replace('%', '', $p->discount_amount);
            return $discountValue >= $discountFilter;
        })->values();
    }

    // ✅ Sort products by highest discount percentage first
    $products = $products->sortByDesc(function ($p) {
        return (float) str_replace('%', '', $p->discount_amount);
    })->values();

    // ✅ Apply pagination after sorting
    $paginated = $products->slice(($page - 1) * $limit, $limit)->values();
    $is_nextpage = ($products->count() > $page * $limit) ? "1" : "0";

    return [
        'products' => $paginated,
        'is_nextpage' => $is_nextpage
    ];
}

function getBrandDealsProductsOnly($brandId = null, $userLat = null, $userLng = null, $discountFilter = null)
{
    $today = Carbon::today()->toDateString();

    // Base query
    $productsQuery = Product::with([
        'offer' => fn($q) => $q->where('status', '1')
                                ->whereDate('start_date', '<=', $today)
                                ->whereDate('end_date', '>=', $today)
    ])
     ->join('categories', 'categories.id', '=', 'products.category_id') 
    ->whereIn('products.is_fashion', ['0', '2'])                             
    ->where('products.status', '1')
    ->select('products.*');    

    if ($brandId) {
        $productsQuery->where('brand_id', $brandId);
    }

    // Fetch all products
    $products = $productsQuery->get();

    // Map products with extra info
    $products = $products->map(function ($product) use ($userLat, $userLng) {
        // Calculate discount
        $discount = 0;
        if (isset($product->offer->discount_type)) {
            if ($product->offer->discount_type === 'percentage') {
                $discount = (float) $product->offer->discount_value;
            } elseif ($product->offer->discount_type === 'fixed' && $product->price > 0) {
                $discount = round(($product->offer->discount_value / $product->price) * 100, 2);
            }
        }
        $product->discount_amount = $discount > 0 ? "{$discount}%" : '';

        // Branch/location
        if (!empty($userLat) && !empty($userLng)) {
            $nearestBranch = getNearestBranch($product->brand_id, $userLat, $userLng);
            $product->location = $nearestBranch ?: (object)[];
        } else {
            $product->location = (object)[];
        }

        // Rating
        $product->rating = ProductRating::totalRating($product->id);

        // Offer object
        $product->offers = $product->offer ?? (object)[];
        unset($product->offer);

        return $product;
    });

    // Filter by discount if provided
    if ($discountFilter) {
        $products = $products->filter(function ($p) use ($discountFilter) {
            $discountValue = (float) str_replace('%', '', $p->discount_amount);
            return $discountValue >= $discountFilter;
        })->values();
    }

    // Sort by highest discount
    $products = $products->sortByDesc(function ($p) {
        return (float) str_replace('%', '', $p->discount_amount);
    })->values();

    return $products;
}




function getBrandTotalDiscountPercentage($brandId)
{
    $today = Carbon::today()->toDateString();

    // Fetch all products under brand that have active offers
    $products = Product::join('offers', 'offers.product_id', '=', 'products.id')
        ->where('products.brand_id', $brandId)
        ->where('offers.status', '1')
        ->whereDate('offers.start_date', '<=', $today)
        ->whereDate('offers.end_date', '>=', $today)
        ->select(
            'products.id',
            'products.price',
            'offers.discount_type',
            'offers.discount_value',
            DB::raw("
                CASE 
                    WHEN offers.discount_type = 'percentage' 
                        THEN offers.discount_value
                    ELSE ROUND((offers.discount_value / products.price) * 100, 2)
                END as discount_percentage
            ")
        )
        ->get();

    if ($products->isEmpty()) {
        return 0; // No active discount
    }

    // Calculate average or total discount percentage
    $averageDiscount = $products->avg('discount_percentage'); // mean %
    $totalDiscount   = $products->sum('discount_percentage'); // total sum of %s if needed

    // You can return either or both
    return round($averageDiscount, 2);
}



function getBrandDiscountPercentage($brandId)
{
    $today = Carbon::today()->toDateString();

    // Fetch all products under brand that have active offers
    $discounts = Product::join('offers', 'offers.product_id', '=', 'products.id')
        ->where('products.brand_id', $brandId)
        ->where('offers.status', '1')
        ->whereDate('offers.start_date', '<=', $today)
        ->whereDate('offers.end_date', '>=', $today)
        ->select(
            'products.id',
            'products.price',
            'offers.discount_type',
            'offers.discount_value'
        )
        ->get()
        ->map(function ($product) {
            $discount = 0;
            
            if ($product->discount_type === 'percentage') {
                $discount = (float) $product->discount_value;
            } elseif ($product->discount_type === 'fixed') {
                $discount = $product->price > 0
                    ? round(($product->discount_value / $product->price) * 100, 2)
                    : 0;
            }

            return $discount;
        })
        ->unique()   // Keep only unique discounts
        ->values();

    return $discounts;
}



function getCategoryDiscountPercentage($category_id)
{
    $today = Carbon::today()->toDateString();

    // Fetch all products under brand that have active offers
    $discounts = Product::join('offers', 'offers.product_id', '=', 'products.id')
        ->where('products.category_id', $category_id)
        ->where('offers.status', '1')
        ->whereDate('offers.start_date', '<=', $today)
        ->whereDate('offers.end_date', '>=', $today)
        ->select(
            'products.id',
            'products.price',
            'offers.discount_type',
            'offers.discount_value'
        )
        ->get()
        ->map(function ($product) {
            $discount = 0;
            
            if ($product->discount_type === 'percentage') {
                $discount = (float) $product->discount_value;
            } elseif ($product->discount_type === 'fixed') {
                $discount = $product->price > 0
                    ? round(($product->discount_value / $product->price) * 100, 2)
                    : 0;
            }

            return $discount;
        })
        ->unique()   // Keep only unique discounts
        ->values();

    return $discounts;
}




function getProductDiscountPercentage($productId)
{
    $today = Carbon::today();

    // Fetch product with its offer
    $product = Product::with(['offer' => function ($q) use ($today) {
            $q->where('status', '1')
              ->whereDate('start_date', '<=', $today)
              ->whereDate('end_date', '>=', $today);
        }])
        ->where('id', $productId)
        ->first();

    if (!$product || !$product->offer) {
        return 0; // no offer
    }

    $offer = $product->offer;
    $discount = 0;

    // Calculate discount %
    if ($offer->discount_type === 'percentage') {
        $discount = (float) $offer->discount_value;
    } else {
        // flat discount to percentage
        $discount = ($product->price > 0)
            ? round(($offer->discount_value / $product->price) * 100, 2)
            : 0;
    }

    // Return as string with %
    return $discount;
}

function getBrandWithProductsAndRatings($brandId) {
    $brandData = Brand::select(
            'brands.id as brand_id',
            'brands.name as brand_name',
            'brands.icon as brand_icon',
            'brands.description',
            DB::raw('COUNT(products.id) as total_products'),
            DB::raw('COALESCE(SUM(product_ratings.rating),0) as total_product_rating'),
            DB::raw('COALESCE(SUM(product_ratings.rating)/NULLIF(COUNT(products.id),0),0) as brand_average_rating')
        )
        ->Join('products', 'products.brand_id', '=', 'brands.id')
        ->Join('product_ratings', 'product_ratings.product_id', '=', 'products.id')
        ->where('brands.id', $brandId)
        ->groupBy('brands.id')
        ->first();
    return $brandData;
}

  

function getbrandBanner($brandId, $type)
{
    $banners = BrandBanner::where('brand_id', $brandId)
        ->where('own_banner', $type)
        ->where('status', '1')
        ->orderByDesc('id')
        ->get();

    if ($banners->isNotEmpty()) {
        $banners = $banners->map(function ($item) {

            $Brand = Brand::where('id',$item->brand_id)->select('name','description','icon')->first();

            $totdiscount = getBrandTotalDiscountPercentage($item->brand_id);
            $rating = getBrandWithProductsAndRatings($item->brand_id);
            if($rating){
                $totrating = $rating['brand_average_rating'];
            }else{
                $totrating = 0;
            }


            if ($totdiscount <= '0') {
                $totdiscount = '';
            } else {
                $totdiscount = (string) $totdiscount . '%';
            }

            $item->discount_amount = $totdiscount;
            $item->brand_name = $Brand->name ?? '';
            $item->brand_description = strip_tags($Brand->description) ?? '';
            $item->brand_image = asset('uploads/brand/'.$Brand->icon ?? '');
            $item->rating = $totrating;

            return $item->toArray();
        });
    }

    return $banners->toArray(); // Return the full array of banners, not just the last item
}

function getNearestBranch($brandId, $userLat, $userLong)
{
    return Branch::select(
        'branches.id',
        'branches.about',
        'branches.brand_id',
        'branches.latitude',
        'branches.longitude',
        'branches.area',
        'branches.city',
        'branches.state',
        'branches.pincode',
        'branches.contact_no',
        'branches.whatsapp_no',
        'branches.address',
        'branches.facebook',
        'branches.twitter',
        'branches.instagram',
        'branches.linkedin',
        'branches.pinterest',
        'branches.is_booking',
        'branches.is_appointment',
        DB::raw("(
            6371 * acos(
                cos(radians($userLat)) 
                * cos(radians(branches.latitude)) 
                * cos(radians(branches.longitude) - radians($userLong)) 
                + sin(radians($userLat)) 
                * sin(radians(branches.latitude))
            )
        ) AS distance_km")
    )
    ->join('offer_branches', 'offer_branches.branch_id', '=', 'branches.id')
    ->join('offers', 'offers.id', '=', 'offer_branches.offer_id')
    ->where('branches.brand_id', $brandId)
    ->where('branches.status', '1')
    ->where('offers.status', '1')
    ->whereDate('offers.start_date', '<=', now()->toDateString())
    ->whereDate('offers.end_date', '>=', now()->toDateString())
    ->orderBy('distance_km', 'asc')
    ->distinct('branches.id')
    ->first(); // nearest branch with an active offer
}

function getNearestOfferBranch($offer_id, $userLat, $userLong)
{
    $lat = $userLat;
    $lng = $userLong;
    $offerId = $offer_id;

    $branch = DB::table('branches')
        ->join('offer_branches', 'offer_branches.branch_id', '=', 'branches.id')
        ->where('offer_branches.offer_id', $offerId)
        ->select(
            'branches.*',
            DB::raw("
                (6371 * acos(
                    cos(radians($lat)) *
                    cos(radians(branches.latitude)) *
                    cos(radians(branches.longitude) - radians($lng)) +
                    sin(radians($lat)) *
                    sin(radians(branches.latitude))
                )) AS distance
            ")
        )
        ->orderBy('distance', 'ASC')  // nearest first
        ->first();

      

    return $branch;
}


function getNearestBookingBranch($brandId, $userLat, $userLong)
{
    return Branch::select(
        'branches.id',
        'branches.brand_id',
        'branches.latitude',
        'branches.longitude',
        'branches.area',
        'branches.city',
        'branches.state',
        'branches.pincode',
        'branches.contact_no',
        'branches.address',
        DB::raw("(
            6371 * acos(
                cos(radians($userLat)) 
                * cos(radians(branches.latitude)) 
                * cos(radians(branches.longitude) - radians($userLong)) 
                + sin(radians($userLat)) 
                * sin(radians(branches.latitude))
            )
        ) AS distance_km")
    )
    ->where('branches.brand_id', $brandId)
    ->where('branches.is_booking', '1')
    ->where('branches.status', '1')
    ->orderBy('distance_km', 'asc')
    ->distinct('branches.id')
    ->first(); 
}

function getNearestAppointmentBranch($brandId, $userLat, $userLong)
{
    return Branch::select(
        'branches.id',
        'branches.brand_id',
        'branches.latitude',
        'branches.longitude',
        'branches.area',
        'branches.city',
        'branches.state',
        'branches.pincode',
        'branches.contact_no',
        'branches.address',
        DB::raw("(
            6371 * acos(
                cos(radians($userLat)) 
                * cos(radians(branches.latitude)) 
                * cos(radians(branches.longitude) - radians($userLong)) 
                + sin(radians($userLat)) 
                * sin(radians(branches.latitude))
            )
        ) AS distance_km")
    )
    ->where('branches.brand_id', $brandId)
    ->where('branches.is_appointment', '1')
    ->where('branches.status', '1')
    ->orderBy('distance_km', 'asc')
    ->distinct('branches.id')
    ->first(); 
}


function similar_product($id,$categoryIds){
    $today = now()->toDateString();

    $similarProducts = Product::with(['offer' => function ($q) use ($today) {
        $q->where('status', '1')
          ->whereDate('start_date', '<=', $today)
          ->whereDate('end_date', '>=', $today);
    }])
    ->whereIn('category_id', $categoryIds)
    ->where('brand_id', '!=', $id)
    ->where('status', '1')
    ->get()
    ->filter(function ($product) {
        // Keep only products that have an offer
        return $product->offer !== null;
    })
    ->map(function ($product) {
        // Calculate discount percentage
        $discount = 0;
        if ($product->offer->discount_type === 'percentage') {
            $discount = (float) $product->offer->discount_value;
        } elseif ($product->offer->discount_type === 'fixed' && $product->price > 0) {
            $discount = round(($product->offer->discount_value / $product->price) * 100, 2);
        }
        $product->discount_amount = "{$discount}%";

        // Move offer to 'offers' key and remove original
        $product->offers = $product->offer;
        unset($product->offer);

        return $product;
    })
    ->values(); // reset keys

    return $similarProducts;
}

function similar_product_with_or_without_offer($id,$categoryIds,$type){
     $today = now()->toDateString();

   $similarProducts = Product::with([
        'offer' => function ($q) use ($today) {
            $q->where('status', '1')
              ->whereDate('start_date', '<=', $today)
              ->whereDate('end_date', '>=', $today);
        }
    ])
    ->where('is_fashion', $type)
    ->whereIn('category_id', $categoryIds)
    ->where('brand_id', '!=', $id)
    ->where('status', '1')
    ->get()
    ->map(function ($product) {
        // Calculate discount
        $discount = 0;
        if ($product->offer) {
            if ($product->offer->discount_type === 'percentage') {
                $discount = (float) $product->offer->discount_value;
            } elseif ($product->offer->discount_type === 'fixed' && $product->price > 0) {
                $discount = round(($product->offer->discount_value / $product->price) * 100, 2);
            }
        }

        $product->discount_amount = $product->offer ? "{$discount}%" : '0%';

        // Move offer to "offers"
        $product->offers = $product->offer ?? (object)[];
        unset($product->offer);

        return $product;
    })
    ->sortByDesc(function ($product) {
        // Sort by: has offer (1 or 0), then discount
        return [
            $product->offers ? 1 : 0,  
            (float) str_replace('%', '', $product->discount_amount)
        ];
    })
    ->values();

    return $similarProducts;
}

function similar_brand_product($product_id,$brand_id,$category_id){
    $today = now()->toDateString();

    $similarProducts = Product::where('brand_id', $brand_id)
    ->where('category_id', $category_id)
     ->where('id','!=', $product_id)
    ->where('status', '1')
    ->take(5)
    ->with(['offer' => function ($q) {
        $q->where('status', '1')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }])
    
    ->get()
    ->map(function ($product) {
        $discount = 0;
        $discount_text = '0%';

        if ($product->offer) {
            if ($product->offer->discount_type === 'percentage') {
                $discount = (float) $product->offer->discount_value;
            } elseif (
                $product->offer->discount_type === 'fixed'
                && $product->price > 0
            ) {
                $discount = round(($product->offer->discount_value / $product->price) * 100, 2);
            }

            $discount_text = "{$discount}%";
        }

        // Add computed values
        $product->discount_amount = $discount_text;
        $product->offers = $product->offer ?? (object)[];
        unset($product->offer);

        return $product;
    })
    ->values(); // reset collection keys

    


    return $similarProducts;

}

function other_brand_product($brand_id,$category_id){
    $today = now()->toDateString();

    $similarProducts = Product::where('brand_id','!=', $brand_id)
    ->where('category_id', $category_id)
    ->where('status', '1')
    ->take(5)
    ->with(['offer' => function ($q) {
        $q->where('status', '1')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }])
    ->get()
    ->map(function ($product) {
        $discount = 0;
        $discount_text = '0%';

        if ($product->offer) {
            if ($product->offer->discount_type === 'percentage') {
                $discount = (float) $product->offer->discount_value;
            } elseif (
                $product->offer->discount_type === 'fixed'
                && $product->price > 0
            ) {
                $discount = round(($product->offer->discount_value / $product->price) * 100, 2);
            }

            $discount_text = "{$discount}%";
        }

        // Add computed values
        $product->discount_amount = $discount_text;
        $product->offers = $product->offer ?? (object)[];
        unset($product->offer);

        return $product;
    })
    ->values(); // reset collection keys

    return $similarProducts;

}



function is_blur($user_id){
    return '0';
}

function brand_like($brandid,$userid){
     $likedata = UserLike::where('user_id', $userid)
                            ->where('brand_id', $brandid)
                            ->first();
     if($likedata){
        if($likedata->status == '1'){
            return '1';
        }else{
            return '0';
        }
     }   
     return '0';                    
}

function product_like($product_id,$userid){
     $likedata = UserLike::where('user_id', $userid)
                            ->where('product_id', $product_id)
                            ->first();
    if($likedata){
        if($likedata->status == '1'){
            return '1';
        }else{
            return '0';
        }
     }   
     return '0';                    
}

function branch_like($branchid,$userid){
     $likedata = UserLike::where('user_id', $userid)
                            ->where('branch_id', $branchid)
                            ->first();
     if($likedata){
        if($likedata->status == '1'){
            return '1';
        }else{
            return '0';
        }
     }   
     return '0';                    
}

function brand_rating($brandId){
    $productIds = Product::where('brand_id', $brandId)->pluck('id');

    if ($productIds->isEmpty()) {
        return 0;
    }

    $count = ProductRating::whereIn('product_id', $productIds)->count();
    $total = ProductRating::whereIn('product_id', $productIds)->sum('rating');

    if ($count === 0) {
        return 0;
    }

    return round($total / $count, 1);
}

function brand_review($brandId){
    $productIds = Product::where('brand_id', $brandId)->pluck('id');

    if ($productIds->isEmpty()) {
        return array();
    }

    $data = ProductRating::whereIn('product_id', $productIds)
            ->with([
                'user:id,first_name,last_name,image',
                'product:id,name,image'
            ])
            ->orderBy('rating', 'desc')
            ->limit(4)
            ->get();
    
    return $data;
}


function getBrandProductImages($brandId)
{
    return Product::where('brand_id', $brandId)
        ->where('status', '1')
        ->orderBy('id', 'desc')
        ->get()
        ->map(fn($p) => $p->image_url)
        ->values();
}

function getProductImages($product_id)
{
    return ProductImage::where('product_id', $product_id)
        ->orderBy('id', 'desc')
        ->get()
        ->map(fn($p) => $p->image_url)
        ->values();
}

function brandmenu($brandid){
    $menu = BrandMenu::where('brand_id',$brandid)->get();
    return $menu;
}

function branchmenu($branchid){
    $menu = BrandMenu::where('branch_id',$branchid)->get();
    return $menu;
}

function brandgallery($brandid){
    $menu = BrandGallery::where('brand_id',$brandid)->get();
    return $menu;
}

function branchgallery($branchid){
    $menu = BrandGallery::where('branch_id',$branchid)->get();
    return $menu;
}



function generate_deep_link($type,$id){
        $code = Str::random(20);

        $link = ShortLink::create([
            'code' => $code,
            'type' => $type,
            'item_id' => $id
        ]);

        return url("/d/{$link->code}");
}
  

function deal_count($product_id){
    $totalUniqueUsers = UserDeal::where('product_id', $product_id)
    ->distinct('user_id')
    ->count('user_id');

    return $totalUniqueUsers;
}

function brand_deal_count($brandid){
$totalUniqueUsers = UserDeal::select(
            'products.id as product_id',
            DB::raw('COUNT(DISTINCT user_deals.user_id) as user_count')
        )
        ->join('products', 'products.id', '=', 'user_deals.product_id')
        ->where('products.brand_id', $brandid)
        ->groupBy('products.id')
        ->get();

    if(!empty($totalUniqueUsers)){
        return count($totalUniqueUsers);
    }    

    return 0;
}

function fashion_deal_count($product_id){
    return 0;
}



function fashion_home_data($uid, $categoryId = null, $page = 1, $limit = 2, $userLat = null, $userLng = null, $search = null)
{
    $today = Carbon::today()->toDateString();
    $start = ($page - 1) * $limit;

    // --- Load categories with relations ---
    $categoriesQuery = Category::with([
        'subcategories' => function ($q) {
            $q->where('status', '1')
              ->select('id', 'category_id', 'name', 'rank','icon')
              ->orderBy('rank', 'asc');
        },
        'brands' => function ($q) use ($today, $search) {
            $q->where('status', '1')
              ->select('id', 'category_id', 'subcategory_id', 'name', 'icon','banner_image', 'description')
            //   ->when($search, fn($q) => $q->where('name', 'like', "%$search%")) // 🔍 Brand search
              ->with([
                  'products' => function ($pq) use ($today, $search) {
                      $pq->select('id', 'brand_id', 'category_id', 'subcategory_id', 'price', 'name', 'image')
                         ->when($search, fn($pq) => $pq->where('name', 'like', "%$search%")) // 🔍 Product search
                         ->with(['offer' => fn($oq) => $oq->where('status', '1')
                                                            ->whereDate('start_date', '<=', $today)
                                                            ->whereDate('end_date', '>=', $today)]);
                  },
                  'branches:id,brand_id,latitude,longitude,city,state,area,pincode'
              ]);
        }
    ])
    ->where('is_fashion', '1')
    ->where('name','!=', 'All')
    ->where('status', '1')
    ->when($categoryId, fn($q) => $q->where('id', $categoryId))
    ->select('id', 'name', 'icon', 'rank', 'status')
    ->orderBy('rank', 'asc');

    // --- Pagination on categories ---
    $totalCategories = $categoriesQuery->count();
    $categories = $categoriesQuery->skip($start)->take($limit)->get();
    $is_nextpage = $totalCategories > ($page * $limit) ? '1' : '0';


    

    // --- Helper: compute brand discount ---
    $computeBrandDiscount = function ($brand) {
        $maxDiscount = 0;
        foreach ($brand->products as $product) {
            $offer = $product->offer ?? null;
            $discount = 0;
            if ($offer) {
                $discount = $offer->discount_type === 'percentage'
                    ? (float) $offer->discount_value
                    : ($product->price > 0
                        ? round(($offer->discount_value / $product->price) * 100, 2)
                        : 0);
            }
            $product->discount_amount = (string) $discount;
            $maxDiscount = max($maxDiscount, $discount);
        }
        $brand->max_discount = (string) $maxDiscount;
        return $brand;
    };

    // --- Helper: find nearest branch ---
    $computeNearestBranch = function ($brand, $userLat, $userLng) {
        if (empty($userLat) || empty($userLng) || $brand->branches->isEmpty()) {
            $brand->nearest_branch = null;
            $brand->distance_km = null;
            return $brand;
        }
        $nearestBranch = null;
        $minDistance = PHP_FLOAT_MAX;
        foreach ($brand->branches as $branch) {
            $distance = haversineDistance($userLat, $userLng, $branch->latitude, $branch->longitude);
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearestBranch = $branch;
            }
        }
        $brand->nearest_branch = $nearestBranch;
        $brand->distance_km = round($minDistance, 2);
        return $brand;
    };

    // --- Build final structured data ---
    $data = [];
    foreach ($categories as $category) {
        $subcategoryList = collect();
        $brandList = collect();
        $productList = collect();

        foreach ($category->subcategories as $sub) {
            $brands = $category->brands->where('subcategory_id', $sub->id);
            $max_discount = 0;

            foreach ($brands as $brand) {
                // Compute brand-level discount and nearest branch
                $brand = $computeBrandDiscount($brand);
                $brand = $computeNearestBranch($brand, $userLat, $userLng);

                $brand_max_discount = 0;

                foreach ($brand->products as $product) {
                    $offer = $product->offer;
                    $discount_percentage = 0;

                    if ($offer) {
                        if ($offer->discount_type === 'percentage') {
                            $discount_percentage = $offer->discount_value;
                        } elseif ($offer->discount_type === 'fixed' && $product->price > 0) {
                            $discount_percentage = ($offer->discount_value / $product->price) * 100;
                        }
                    }

                    $brand_max_discount = max($brand_max_discount, $discount_percentage);
                    $rating = ProductRating::totalRating($product->id);
                    $productlikestatus = $uid ? product_like($product->id,$uid) : '0';
                    $deal_count = fashion_deal_count($product->id);
                    $view_count = ProductView::totalCount($product->id);

                    $newprice = 0;                    
                    if($offer){
                        if($offer->discount_type == 'fixed'){
                            $newprice = $product->price - $offer->discount_value;
                        }else{
                            $discount_val = ($product->price * $offer->discount_value) / 100;
                            $newprice = $product->price - $discount_val;
                        }
                    }   

                    $branch = getNearestBranch($brand->id, $userLat, $userLng);

                    if($newprice == 0){
                        $old_price = "0";
                        $price = $product->price;
                    }else{
                        $old_price = $product->price;
                        $price = $newprice;
                    }

                    $productList->push([
                        'category_id' => $product->category_id,
                        'subcategory_id' => $product->subcategory_id,
                        'brand_id' => $product->brand_id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'old_price' => $old_price,
                        'price' => $price,
                        'image_url' => asset('uploads/product/' . $product->image),
                        'discount_percentage' => round($discount_percentage, 2) . '%',
                        'brand_name' => $brand->name,
                        'brand_image_url' => asset('uploads/brand/' . $brand->icon),
                        'offer' => $offer ?? (object)[],
                        'nearest_branch' => $branch ? $branch : (object)[],
                        'rating' => $rating,
                        'like_status' => $productlikestatus,
                        'deal_count' => $deal_count,
                        'view_count' => $view_count
                    ]);
                }

                $brand->max_discount = round($brand_max_discount, 2);
                $brandrating = brand_rating($brand->id);

                $brandList->push([
                    'brand_id' => $brand->id,
                    'brand_name' => $brand->name,
                    'description' => $brand->description,
                    'image_url' => asset('uploads/brand/' . $brand->icon),
                    'banner_image_url' => asset('uploads/brand/' . $brand->banner_image),
                    'max_discount' => $brand->max_discount . '%',
                    'best_offer' => 'Flat ' . $brand->max_discount . '% discount',
                    'distance_km' => $brand->distance_km ?? 0,
                    'nearest_branch' => $brand->nearest_branch ? $brand->nearest_branch : (object)[],
                    'rating' =>  $brandrating
                ]);

                $max_discount = max($max_discount, $brand->max_discount);
            }

            $subcategoryList->push([
                'subcategory_id' => $sub->id,
                'subcategory_name' => $sub->name,
                'icon' => asset('uploads/subcategory/' . $sub->icon),
                'max_discount' => round($max_discount, 2) . '%',
            ]);
        }

        // --- Sort ---
        $brandList = $brandList->sortByDesc('max_discount')->values();
        $productList = $productList->sortByDesc('discount_percentage')->values();
        $subcategoryList = $subcategoryList->sortByDesc('max_discount')->values();

        $total = $productList->count();
        $half = ceil($total / 2);
        $firstHalf = $productList->filter(function ($item) {
            $discount = floatval(str_replace('%', '', $item['discount_percentage']));
            return $discount >= 50; // include products with 50% or less discount
        })->values();

        $secondHalf = $productList->filter(function ($item) {
            $discount = floatval(str_replace('%', '', $item['discount_percentage']));
            return $discount < 50; // include products with more than 50% discount
        })->values();

        $is_view_all = 0;
        if (empty($categoryId)) {
            $secondHalf = $secondHalf->take(4)->values();
            if ($secondHalf->count() >= 4) {
                $is_view_all = 1;
            }
        }

        $FashionOfferBanner = FashionOfferBanner::where('category_id',$category->id)
            ->where('status','1')->get();

        $data[] = [
            'category_id' => $category->id,
            'category_name' => $category->name,
            'icon' => asset('uploads/category/' . $category->icon),
            'subcategory' => $subcategoryList,
            'brand' => $brandList,
            'product' => $firstHalf,
            'offer_banner' => $FashionOfferBanner,
            'new_on_wah_deal' => $secondHalf,
            'is_view_all' => $is_view_all
        ];
    }

    return [
        'data' => $data,
        'is_nextpage' => $is_nextpage,
    ];
}


function shoping_category_product($uid, $categoryId = null, $subcategoryId = null, $brandId = null, $page = 1, $limit = 10, $filters = [], $userLat = null, $userLng = null)
{
    $today = Carbon::today()->toDateString();
    $start = ($page - 1) * $limit;

    $minDiscount = $filters['discount'] ?? 0;
    $minRating   = $filters['rating'] ?? 0;
    $offerType   = $filters['offer_type'] ?? null;

    // --- Base query ---
    $query = Product::with([
        'category:id,name,icon,is_fashion',
        'subcategory:id,category_id,name,icon',
        'brand' => function ($q) {
            $q->select('id', 'name', 'icon', 'banner_image', 'description')
              ->with(['branches:id,brand_id,latitude,longitude,city,state,area,pincode,address']);
        },
        'offer' => function ($q) use ($today) {
            $q->where('status', '1')
              ->whereDate('start_date', '<=', $today)
              ->whereDate('end_date', '>=', $today);
        }
    ])
    ->join('categories', 'categories.id', '=', 'products.category_id')   // JOIN ADDED
    ->whereIn('products.is_fashion', ['1', '2'])                                     // APPLY FILTER
    ->select('products.*')                                                // FIX DUPLICATE COLUMN ISSUE
    ->when($categoryId, fn($q) => $q->where('products.category_id', $categoryId))
    ->when($subcategoryId, fn($q) => $q->where('products.subcategory_id', $subcategoryId))
    ->when($brandId, fn($q) => $q->where('products.brand_id', $brandId))
    ->where('products.status', '1');

    $allProducts = $query->get();

    $processed = $allProducts->map(function ($product) use ($uid, $minDiscount, $minRating, $offerType, $userLat, $userLng) {
        $offer = $product->offer;
        $discount_percentage = 0;

        if ($offer) {
            if ($offer->discount_type === 'percentage') {
                $discount_percentage = $offer->discount_value;
            } elseif ($offer->discount_type === 'fixed' && $product->price > 0) {
                $discount_percentage = ($offer->discount_value / $product->price) * 100;
            }
        }

        $rating = ProductRating::totalRating($product->id);
        $like_status = $uid ? product_like($product->id, $uid) : '0';

        // --- Apply filter checks ---
        if ($discount_percentage < $minDiscount) return null;
        if ($rating < $minRating) return null;
        if ($offerType && (!isset($offer->offer_type) || $offer->offer_type != $offerType)) return null;

        // --- Nearest branch logic ---
        $nearestBranch = null;
        $distance = null;

        if ($userLat && $userLng && isset($product->brand->branches)) {
            $nearest = null;
            $nearestDistance = PHP_FLOAT_MAX;

            foreach ($product->brand->branches as $branch) {
                $d = haversineDistance($userLat, $userLng, $branch->latitude, $branch->longitude);
                if ($d < $nearestDistance) {
                    $nearestDistance = $d;
                    $nearest = $branch;
                }
            }

            if ($nearest) {
                $nearestBranch = [
                    'branch_id' => $nearest->id,
                    'city' => $nearest->city,
                    'state' => $nearest->state,
                    'area' => $nearest->area,
                    'pincode' => $nearest->pincode,
                    'address' => $nearest->address,
                    'latitude' => $nearest->latitude,
                    'longitude' => $nearest->longitude,
                    'distance_km' => round($nearestDistance, 2),
                ];
                $distance = $nearestDistance;
            }
        }

        $newprice = 0;                    
        if($offer){
            if($offer->discount_type == 'fixed'){
                        $newprice = $product->price - $offer->discount_value;
            }else{
                $discount_val = ($product->price*$offer->discount_value)/100;
                $newprice = $product->price - $discount_val;
            }
        }

        if($newprice == 0){
            $old_price = "0";
            $price = $product->price;
        }else{
            $old_price = $product->price;
            $price = $newprice;
        }

        return [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'category_id' => $product->category_id,
            'category_name' => $product->category->name ?? '',
            'subcategory_id' => $product->subcategory_id,
            'subcategory_name' => $product->subcategory->name ?? '',
            'brand_id' => $product->brand->id ?? '',
            'brand_name' => $product->brand->name ?? '',
            'brand_image_url' => asset('uploads/brand/' . ($product->brand->icon ?? '')),
            'old_price' => $old_price,
            'price' => $price,
            'image_url' => asset('uploads/product/' . $product->image),
            'discount_percentage' => round($discount_percentage, 2) . '%',
            'rating' => $rating,
            'deal_count' => fashion_deal_count($product->id),
            'view_count' => ProductView::totalCount($product->id),
            'like_status' => $like_status,
            'offer' => $offer ?? (object)[],
            'nearest_branch' => $nearestBranch,
            'distance_km' => $distance ? round($distance, 2) : null,
        ];
    })->filter()->values();

    // --- Sort by nearest branch first, then best offer ---
    $processed = $processed->sort(function ($a, $b) {
        // Distance-based sorting
        if (!is_null($a['distance_km']) && is_null($b['distance_km'])) return -1;
        if (is_null($a['distance_km']) && !is_null($b['distance_km'])) return 1;

        if (!is_null($a['distance_km']) && !is_null($b['distance_km'])) {
            if ($a['distance_km'] != $b['distance_km']) return $a['distance_km'] <=> $b['distance_km'];
        }

        // If distance same — sort by discount desc
        return $b['discount_percentage'] <=> $a['discount_percentage'];
    })->values();

    // --- Pagination ---
    $total = $processed->count();
    $paged = $processed->slice($start, $limit)->values();
    $is_nextpage = $total > ($page * $limit) ? '1' : '0';

    return [
        'data' => $paged,
        'is_nextpage' => $is_nextpage,
    ];
}



function category_product($uid, $categoryId = null, $subcategoryId = null, $brandId = null, $page = 1, $limit = 10, $filters = [], $userLat = null, $userLng = null)
{
    $today = Carbon::today()->toDateString();
    $start = ($page - 1) * $limit;

    $minDiscount = $filters['discount'] ?? 0;
    $minRating   = $filters['rating'] ?? 0;
    $offerType   = $filters['offer_type'] ?? null;

    // --- Base query ---
    $query = Product::with([
        'category:id,name,icon',
        'subcategory:id,category_id,name,icon',
        'brand' => function ($q) {
            $q->select('id', 'name', 'icon', 'banner_image', 'description')
              ->with(['branches:id,brand_id,latitude,longitude,city,state,area,pincode,address']);
        },
        'offer' => function ($q) use ($today) {
            $q->where('status', '1')
              ->whereDate('start_date', '<=', $today)
              ->whereDate('end_date', '>=', $today);
        }
    ])
    ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
    ->when($subcategoryId, fn($q) => $q->where('subcategory_id', $subcategoryId))
    ->when($brandId, fn($q) => $q->where('brand_id', $brandId))
    ->where('status', '1');

    $allProducts = $query->get();

    $processed = $allProducts->map(function ($product) use ($uid, $minDiscount, $minRating, $offerType, $userLat, $userLng) {
        $offer = $product->offer;
        $discount_percentage = 0;

        if ($offer) {
            if ($offer->discount_type === 'percentage') {
                $discount_percentage = $offer->discount_value;
            } elseif ($offer->discount_type === 'fixed' && $product->price > 0) {
                $discount_percentage = ($offer->discount_value / $product->price) * 100;
            }
        }

        $rating = ProductRating::totalRating($product->id);
        $like_status = $uid ? product_like($product->id, $uid) : '0';

        // --- Apply filter checks ---
        if ($discount_percentage < $minDiscount) return null;
        if ($rating < $minRating) return null;
        if ($offerType && (!isset($offer->offer_type) || $offer->offer_type != $offerType)) return null;

        // --- Nearest branch logic ---
        $nearestBranch = null;
        $distance = null;

        if ($userLat && $userLng && isset($product->brand->branches)) {
            $nearest = null;
            $nearestDistance = PHP_FLOAT_MAX;

            foreach ($product->brand->branches as $branch) {
                $d = haversineDistance($userLat, $userLng, $branch->latitude, $branch->longitude);
                if ($d < $nearestDistance) {
                    $nearestDistance = $d;
                    $nearest = $branch;
                }
            }

            if ($nearest) {
                $nearestBranch = [
                    'branch_id' => $nearest->id,
                    'city' => $nearest->city,
                    'state' => $nearest->state,
                    'area' => $nearest->area,
                    'pincode' => $nearest->pincode,
                    'address' => $nearest->address,
                    'latitude' => $nearest->latitude,
                    'longitude' => $nearest->longitude,
                    'distance_km' => round($nearestDistance, 2),
                ];
                $distance = $nearestDistance;
            }
        }

        $newprice = 0;                    
        if($offer){
            if($offer->discount_type == 'fixed'){
                        $newprice = $product->price - $offer->discount_value;
            }else{
                $discount_val = ($product->price*$offer->discount_value)/100;
                $newprice = $product->price - $discount_val;
            }
        }

        if($newprice == 0){
            $old_price = "0";
            $price = $product->price;
        }else{
            $old_price = $product->price;
            $price = $newprice;
        }

        return [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'category_id' => $product->category_id,
            'category_name' => $product->category->name ?? '',
            'subcategory_id' => $product->subcategory_id,
            'subcategory_name' => $product->subcategory->name ?? '',
            'brand_id' => $product->brand->id ?? '',
            'brand_name' => $product->brand->name ?? '',
            'brand_image_url' => asset('uploads/brand/' . ($product->brand->icon ?? '')),
            'old_price' => $old_price,
            'price' => $price,
            'image_url' => asset('uploads/product/' . $product->image),
            'discount_percentage' => round($discount_percentage, 2) . '%',
            'rating' => $rating,
            'deal_count' => fashion_deal_count($product->id),
            'view_count' => ProductView::totalCount($product->id),
            'like_status' => $like_status,
            'offer' => $offer ?? (object)[],
            'nearest_branch' => $nearestBranch,
            'distance_km' => $distance ? round($distance, 2) : null,
        ];
    })->filter()->values();

    // --- Sort by nearest branch first, then best offer ---
    $processed = $processed->sort(function ($a, $b) {
        // Distance-based sorting
        if (!is_null($a['distance_km']) && is_null($b['distance_km'])) return -1;
        if (is_null($a['distance_km']) && !is_null($b['distance_km'])) return 1;

        if (!is_null($a['distance_km']) && !is_null($b['distance_km'])) {
            if ($a['distance_km'] != $b['distance_km']) return $a['distance_km'] <=> $b['distance_km'];
        }

        // If distance same — sort by discount desc
        return $b['discount_percentage'] <=> $a['discount_percentage'];
    })->values();

    // --- Pagination ---
    $total = $processed->count();
    $paged = $processed->slice($start, $limit)->values();
    $is_nextpage = $total > ($page * $limit) ? '1' : '0';

    return [
        'data' => $paged,
        'is_nextpage' => $is_nextpage,
    ];
}

function get_cart($user, $couponcode = ''){
    $today = Carbon::today()->toDateString();
    $user_lat = $user->latitude;
    $user_long = $user->longitude;

    $useraddress = UserAddress::where('user_id',$user->id)->get();

    $cartItems = Cart::with(['product'])
                ->where('user_id', $user->id)
                ->where('status','0')
                ->get();

    $cartData = [];
    $sub_total = 0;
    $shiping = 0;
    $gst = 0;
    $total_gst_amount = 0;
    $Similar_Data = [];
    foreach ($cartItems as $item) {

        $offer = Offer::where('id', $item->offer_id)->first();
        $product = Product::where('id',$item->product_id)->first();
        

        $newprice = 0;      
        $productprice = $product->price;   
        if($item->size_id && $item->color_id){
            $exists_size_color_price = ProductSizeColorPrice::where('product_id', $item->product_id)
                        ->where('size_id', $item->size_id)
                        ->where('color_id', $item->color_id)
                        ->first();

            if($exists_size_color_price){
                $productprice = $exists_size_color_price->price;
            }            
        }

        $cart_discount_amt = 0;
        if($offer){
            if($offer->discount_type == 'fixed'){
                $newprice = $productprice - $offer->discount_value;
                $discount_val = $offer->discount_value;
                $cart_discount_amt = ($discount_val / $productprice) * 100;
            }else{
                $discount_val = ($productprice*$offer->discount_value)/100;
                $newprice = $productprice - $discount_val;
                $cart_discount_amt = $offer->discount_value;
            }
        }

        if($newprice == 0){
            $old_price = "0";
            $price = $productprice;
        }else{
            $old_price = $productprice;
            $price = $newprice;
        }

        if($cart_discount_amt > 0){
            $cart_discount_text = "{$cart_discount_amt}%";
        }else{
            $cart_discount_text = "";
        }

        $similarProducts = similar_brand_product($product->id,$product->brand_id,$product->category_id);
        
        
        if(!empty($similarProducts)){
            foreach ($similarProducts as $val) {
                $branddata = Brand::find($val['brand_id']);
                $prodLikeStatus = $user ? product_like($val['id'], $user->id) : '0';
                $pro_near_location = getNearestBranch($val['brand_id'], $user_lat, $user_long);



                $offerData = $val['offers'] ?? (object) [];
                $spnewprice = 0;    
                $discount_amt = 0;                
                if($offerData && is_object($offerData) && count((array)$offerData) > 0){
                    if($offerData->discount_type == 'fixed'){
                        $spnewprice = $val['price'] - $offerData->discount_value;
                        $discount_amt = ($offerData->discount_value / $val['price']) * 100;

                    }else{
                        $discount_val = ($val['price']*$offerData->discount_value)/100;
                        $spnewprice = $val['price'] - $discount_val;

                        $discount_amt = $offerData->discount_value;
                    }
                }

                $discount_text = "{$discount_amt}%";

                if($spnewprice == 0){
                    $smold_price = "0";
                    $smprice = $val['price'];
                }else{
                    $smold_price = $val['price'];
                    $smprice = $spnewprice;
                }

                $Similar_Data[] = [
                    'id'           => $val['id'],
                    'name'         => $val['name'],
                    'new_price'        => $smprice,
                    'old_price'    => $smold_price,
                    'discount_amount' =>$discount_text,
                    'like_status'  => $prodLikeStatus,
                    'rating'       => ProductRating::totalRating($val['id']),
                    'view_count'   => ProductView::totalCount($val['id']),
                    'deal_count'   => fashion_deal_count($val['id']),
                    'brand_id' => $branddata ? $branddata->id : '',
                    'brand_name'  => $branddata ? $branddata->name : '',
                    'brand_image'  => $branddata ? asset('uploads/brand/' . $branddata->icon) : '',
                    'image_url'        => asset('uploads/product/' . $val['image']),
                    'location'     => $pro_near_location ?: (object)[],
                    'offers'        => $offerData ?? (object)[],
                ];
            }
        }

        $allSizes = ProductSize::
                    join('sizes', 'product_sizes.size_id', '=', 'sizes.id')
                    ->where('product_sizes.product_id', $item->product_id)
                    ->select('sizes.id', 'sizes.name')
                    ->groupBy('sizes.id')
                    ->get()
                    ->map(function ($s) use ($item) {
                        return [
                            'id' => $s->id,
                            'name' => $s->name,
                            'is_selected' => $item->size_id == $s->id ? 1 : 0,
                        ];
                    });

        $allColors = ProductColor::
                    join('colors', 'product_colors.color_id', '=', 'colors.id')
                    ->where('product_colors.product_id', $item->product_id)
                    ->select('colors.id', 'colors.name', 'colors.color_code')
                    ->groupBy('colors.id')
                    ->get()
                    ->map(function ($c) use ($item) {
                        return [
                            'id' => $c->id,
                            'name' => $c->name,
                            'color_code' => $c->color_code,
                            'is_selected' => $item->color_id == $c->id ? 1 : 0,
                        ];
                    });

    

        $cartData[] = [
            'id'      => $item->id,
            'product_id'   => $item->product_id,
            'product_name' => $item->product ? $item->product->name : '',
            'product_image'=> asset('uploads/product/' . $item->product->image),
            'quantity'     => $item->quantity,
            'price'        => $price,
            'old_price' => $old_price,
            'discount'     => $item->discount,
            'discount_text' => $cart_discount_text,
            'final_price'     => $item->final_price,
            'offer' => $offer,
            'size_list' => $allSizes,
            'color_list' => $allColors,
        ];

        $sub_total = $sub_total + $item->final_price;

        $shipcharger = get_shiping_charge();
        $gstcharge = get_gst_charge($item->product_id);
        $shiping = $shiping + $shipcharger;
        $gst = $gst + $gstcharge;
        $total_gst_amount = $total_gst_amount + $item->gst_price;
    }    
    
    
    $application_discount = getapplicationdiscount();
    $total_amount = $sub_total + $shiping - $application_discount;
    

     $couponcodemsg = '';
     $coupon_code_discount_val = 0;
     $coupon_code_key = '';
     $get_charge_key = '';
    if($couponcode != ''){
        $coupon_code = CouponCode::where('code',$couponcode)
        ->whereDate('end_date', '>=', $today)
         ->where('type','2')
        ->where('status','1')
        ->first();

        if($coupon_code){
            $alreadycouponuser = usedcoupon($coupon_code->id,$user->id);
            $uselimit = $coupon_code->usage_limit;
            if($uselimit > $alreadycouponuser){
                    if($coupon_code->discount_type == 'fixed'){
                        $coupon_code_discount_val = $total_amount - $coupon_code->discount_value;
                        $coupon_code_key = (int) $coupon_code->discount_value .'Rs promo code bonus';
                    }else{
                        $coupon_code_discount_val = ($total_amount*$coupon_code->discount_value)/100;
                        $coupon_code_key = (int) $coupon_code->discount_value .'% promo code bonus';
                    }
                    $couponcodemsg = 'Coupon code applied success';
            }else{
                $couponcodemsg = 'Coupon code already applied';
            }

        }else{
            
        }
    }    

    
    $gst_charge_key = $gst. '% gst charge';

    $charge_val = [
        'subtotal' => $sub_total,
        'shipping' => $shiping,
        'application discount' => $application_discount,
    ];

    if (!empty($coupon_code_key) && !empty($coupon_code_discount_val)) {
        $charge_val[$coupon_code_key] = $coupon_code_discount_val;
    }

    if (!empty($gst_charge_key) && !empty($total_gst_amount) && $total_gst_amount > 0) {
            $charge_val[$gst_charge_key] = $total_gst_amount;
    }

    $charge = collect($charge_val)->map(function ($value, $key) use($gst_charge_key,$coupon_code_key) {
            if($key == 'subtotal'){
                $cdtype = 'Credit';
            }else if($key == 'shipping'){
                $cdtype = 'Credit';
            }else if($key == $gst_charge_key){
                $cdtype = 'Credit';
            }else if($key == 'application discount'){
                $cdtype = 'Debit';
            }else if($key == $coupon_code_key){
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


   $Similar_Data = collect($Similar_Data)
    ->unique('id')   // unique by 'id' key
    ->values()        // reindex 0..n-1
    ->toArray();

    $cart['cart_data'] = $cartData;
    $cart['similar_product'] = $Similar_Data;
    $cart['delivery_detail'] = $useraddress;
    $cart['delivery_by'] = delivery_by();
    $cart['charge'] = $charge;
    $cart['coupon_code_msg'] = $couponcodemsg;

    return $cart;
}


function delivery_by(){
    return 'Delivery by today';
}

function get_shiping_charge(){
    return 100;
}

function get_gst_charge($product_id){
    $product = Product::where('id',$product_id)->first();
    return $product->gst;
}

function getapplicationdiscount(){
    return 0;
}



function usedcoupon($id,$uid){
    $total = UserCouponCode::where('coupon_code_id',$id)->where('user_id',$uid)->count();
    return $total;
}

function get_order_no(){
    $order = Order::orderBy('id', 'desc')->first();
    if($order){
        $oid = $order->id;
    }else{
        $oid = 0;
    }

    $ono = $oid+1;

    $order_number = 'ORD' . strtoupper(uniqid()) . $ono;
    return $order_number;
}

function get_time_line($order){
    $timeline = [];

    // 1: Confirmed
    $timeline[] = [
        'name'   => 'Confirmed',
        'active' => $order->order_status >= 1,
        'date'   => $order->created_at->format('d M'),
    ];

    // If order Cancelled (5)
    if ($order->order_status == 5) {
        $timeline[] = [
            'name'   => 'Cancelled',
            'active' => true,
            'date'   => $order->created_at->addDays(1)->format('d M'),
        ];
    }

    // If order Returned (6)
    if ($order->order_status == 6) {
        $timeline[] = [
            'name'   => 'Return',
            'active' => true,
            'date'   => $order->created_at->addDays(1)->format('d M'),
        ];
    }

    // Continue normal flow if not cancelled/returned
    if ($order->order_status < 5) {

        $timeline[] = [
            'name'   => 'Shipped',
            'active' => $order->order_status >= 2,
            'date'   => $order->created_at->addDays(1)->format('d M'),
        ];

        $timeline[] = [
            'name'   => 'On the Way',
            'active' => $order->order_status >= 3,
            'date'   => $order->created_at->addDays(1)->format('d M'),
        ];

        $timeline[] = [
            'name'   => 'Delivered',
            'active' => $order->order_status >= 4,
            'date'   => $order->created_at->addDays(1)->format('d M'),
        ];
    }

    return $timeline;
}

  


function cancel_cart($order_id, $itemid, $couponcode, $user){
    $today = Carbon::today()->toDateString();

    $cartItems = OrderDetail::where('order_id', $order_id)
                ->where('id','!=',$itemid)
                ->get();

    $cartData = [];
    $sub_total = 0;
    $shiping = 0;
    $gst = 0;
    $total_gst_amount = 0;
    $Similar_Data = [];
    foreach ($cartItems as $item) {

        $offer = Offer::where('id', $item->offer_id)->first();
        $product = Product::where('id',$item->product_id)->first();
        

        $newprice = 0;      
        $productprice = $product->price;   
        if($item->size_id && $item->color_id){
            $exists_size_color_price = ProductSizeColorPrice::where('product_id', $item->product_id)
                        ->where('size_id', $item->size_id)
                        ->where('color_id', $item->color_id)
                        ->first();

            if($exists_size_color_price){
                $productprice = $exists_size_color_price->price;
            }            
        }

        $cart_discount_amt = 0;
        if($offer){
            if($offer->discount_type == 'fixed'){
                $newprice = $productprice - $offer->discount_value;
                $discount_val = $offer->discount_value;
                $cart_discount_amt = ($discount_val / $productprice) * 100;
            }else{
                $discount_val = ($productprice*$offer->discount_value)/100;
                $newprice = $productprice - $discount_val;
                $cart_discount_amt = $offer->discount_value;
            }
        }

        if($newprice == 0){
            $old_price = "0";
            $price = $productprice;
        }else{
            $old_price = $productprice;
            $price = $newprice;
        }

        if($cart_discount_amt > 0){
            $cart_discount_text = "{$cart_discount_amt}%";
        }else{
            $cart_discount_text = "";
        }

       
        $sub_total = $sub_total + $item->final_price;

        $shipcharger = get_shiping_charge();
        $gstcharge = get_gst_charge($item->product_id);
        $shiping = $shiping + $shipcharger;
        $gst = $gst + $gstcharge;
        $total_gst_amount = $total_gst_amount + $item->gst_price;
    }    
    
    
    $application_discount = getapplicationdiscount();
    $total_amount = $sub_total + $shiping - $application_discount;
    

     $couponcodemsg = '';
     $coupon_code_discount_val = 0;
     $coupon_code_key = '';
     $get_charge_key = '';
    if($couponcode != ''){
        $coupon_code = CouponCode::where('code',$couponcode)
        ->whereDate('end_date', '>=', $today)
         ->where('type','2')
        ->where('status','1')
        ->first();

        if($coupon_code){
            $alreadycouponuser = usedcoupon($coupon_code->id,$user->id);
          
            if($coupon_code->discount_type == 'fixed'){
                $coupon_code_discount_val = $total_amount - $coupon_code->discount_value;
                $coupon_code_key = (int) $coupon_code->discount_value .'Rs promo code bonus';
            }else{
                $coupon_code_discount_val = ($total_amount*$coupon_code->discount_value)/100;
                $coupon_code_key = (int) $coupon_code->discount_value .'% promo code bonus';
            }
            $couponcodemsg = 'Coupon code applied success';
            

        }else{
            
        }
    }    

    
    $gst_charge_key = $gst. '% gst charge';

    $charge_val = [
        'subtotal' => $sub_total,
        'shipping' => $shiping,
        'application discount' => $application_discount,
    ];

    if (!empty($coupon_code_key) && !empty($coupon_code_discount_val)) {
        $charge_val[$coupon_code_key] = $coupon_code_discount_val;
    }

    if (!empty($gst_charge_key) && !empty($total_gst_amount) && $total_gst_amount > 0) {
            $charge_val[$gst_charge_key] = $total_gst_amount;
    }

    $charge = collect($charge_val)->map(function ($value, $key) use($gst_charge_key,$coupon_code_key) {
            if($key == 'subtotal'){
                $cdtype = 'Credit';
            }else if($key == 'shipping'){
                $cdtype = 'Credit';
            }else if($key == $gst_charge_key){
                $cdtype = 'Credit';
            }else if($key == 'application discount'){
                $cdtype = 'Debit';
            }else if($key == $coupon_code_key){
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


    $cart['charge'] = $charge;

    return $cart;
}

function order_detail($order_id,$user){
        $order = Order::with([
                    'details.product:id,name,image',
                    'details.size:id,name',
                    'details.color:id,name,color_code'
                ])->find($order_id);

        if (!$order) {
            return sendError(array(), 'Order not exists'); 
        }


        $product_list = $order->details->map(function ($item) {

                    $product = Product::where('id',$item->product_id)->first();


                    return [
                        'id'         => $item->id,
                        'product_id' => $item->product_id,
                        'name'       => $item->product->name ?? '',
                        'price'       => $item->price ?? '',
                        'image'      => asset('uploads/product/' . $item->product->image) ?? '',
                        'size'       => $item->size->name ?? '',
                        'color'      => $item->color->name ?? '',
                        'quantity'   => $item->quantity,
                        'status'     => $item->cart_status_text,
                        'is_cancelled'     => $product->is_cart_cancel_product,
                    ];
        });

        $timeline = get_time_line($order);

        $charge = json_decode($order->charge, true);
        // if (is_string($charge)) {
        //     $charge = json_decode($charge, true);
        // }

        $useraddress = UserAddress::where('user_id',$user->id)->get();

        $cancel_reason = OrderDetail::cancelreasonList();
        
        
        
        if($order->order_status > 3){
                $delivery_date = '';
        }else{
            $delivery_date = $order->created_at->addDay();
        } 


        $cancelcount = OrderDetail::where('order_id',$order->id)->where('order_status','5')->count();
        $totalcount = OrderDetail::where('order_id',$order->id)->count();

        if($cancelcount == $totalcount){
            $full_order_is_cancelled = '0';  
        }else{
            $full_order_is_cancelled = '1';  
        }


        $data = [
            'order_id'        => $order->id,
            'order_number'    => $order->order_number,
            'order_status'    => $order->order_status_text,
            'order_delivered_date'    => $delivery_date,
            'order_delivered_contact_no' => '9909889098',
            'products'        => $product_list,
            'timeline'        => $timeline,
            'delivery_detail' => $order->userAddress,
            'charge'        => $charge,
            'payment_method_text' => $order->payment_method_text,
            'user_address' => $useraddress,
            'cancel_reason' => $cancel_reason,
            'is_cancelled'     => $full_order_is_cancelled,
            'order_cancel_reason' => $order->cancel_note,
            
        ];

        return $data;
}

function cart_product_exists($user_id,$product_id){
    $exists = Cart::where('user_id', $user_id)
              ->where('product_id', $product_id)
              ->where('status','0')
              ->first();

    if($exists){
        return '1';
    }
    
    return '0';
}

function getstaticlatlong(){
    $user_lat = '21.23667458588156';
    $user_long = '72.86241705266787';

    $data['lat'] = $user_lat;
    $data['long'] = $user_long;

    return $data;
}

function generate_password(int $length = 8): string
{
        $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digits  = '0123456789';
        $all     = $letters . $digits;

        // Ensure at least one letter and one digit
        $passwordChars = [];
        $passwordChars[] = $letters[random_int(0, strlen($letters) - 1)];
        $passwordChars[] = $digits[random_int(0, strlen($digits) - 1)];

        // Fill the rest
        for ($i = 2; $i < $length; $i++) {
            $passwordChars[] = $all[random_int(0, strlen($all) - 1)];
        }

        // Shuffle securely
        for ($i = count($passwordChars) - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            [$passwordChars[$i], $passwordChars[$j]] = [$passwordChars[$j], $passwordChars[$i]];
        }

        return implode('', $passwordChars);
}

function getBranchRoles()
{
    $loginbranchdata = Auth::guard('brand')->user();
    $loginbranchId = $loginbranchdata->id;

    if(!$loginbranchId) return [];

    return Role::where('branch_id', $loginbranchId)
               ->pluck('role')
               ->toArray();
}


function getBranchRequestCount()
{
    $tot = BranchChangeRequest::where('status','pending')->count();
    return $tot;
}


function send_otp($mobileNumber,$otp){
     $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://control.msg91.com/api/v5/otp?template_id=64d1cd90d6fc0554552d7032&mobile=91".$mobileNumber."&otp=".$otp,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "authkey: 402941AZXuEbdz64d1c980P1",
            "content-type: application/json"
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);


        $responseData = json_decode($response, true);

        return $responseData;
}


function staticformfield(){
    $staticFields = [
                        [
                            'label' => 'User Full Name',
                            'name' => 'User Full Name',
                            'type' => 'text',
                            'options' => null,
                            'options_selection' => null,
                            'is_required' => '1',
                            'sort_order' => '1'
                        ],
                        [
                            'label' => 'Phone Number',
                            'name' => 'Phone Number',
                            'type' => 'number',
                            'options' => null,
                            'options_selection' => null,
                            'is_required' => '1',
                            'sort_order' => '2'
                        ],
                        [
                            'label' => 'Email',
                            'name' => 'Email',
                            'type' => 'email',
                            'options' => null,
                            'options_selection' => null,
                            'is_required' => '0',
                            'sort_order' => '3'
                        ],
                        [
                            'label' => 'Gender',
                            'name' => 'Gender',
                            'type' => 'radio',
                            'options' => json_encode(['Male','Female']),
                            'options_selection' => 'single',
                            'is_required' => '1',
                            'sort_order' => '4'
                        ],
                ];

                return $staticFields;
}