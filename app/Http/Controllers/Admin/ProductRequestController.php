<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ProductImage;
use App\Models\ProductRating;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductSizeColorPrice;
use App\Models\OfferType;
use App\Models\Offer;
use App\Models\OfferBranch;
use App\Models\BranchProductRequest;
use App\Models\Branch;

class ProductRequestController extends Controller
{
    public function index()
    {
        return view('admin.product_request');
    }

    public function get_list(Request $request)
    {
        
        if ($request->ajax()) 
        {
            $start = $request->get('start', 0);
            $length = $request->get('length', 10); 
            $orderColumn = $request->input('order_column');
            $orderDir = $request->input('order_dir', 'asc');
            $search = $request->get('search')['value'];
            $columns = ['id'];

            $query = BranchProductRequest::where('id','!=',0);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('product', 'like', "%{$search}%");
                });
            }
        
            $query = $query->orderBy($columns[$orderColumn], $orderDir);


            $filtertotalget =  $query->get();
            $users = $query->skip($start)->take($length)->get();


            $totalRecords = BranchProductRequest::count();
            $filteredRecords = count($filtertotalget);

        
            $i =  $request->get('start');
            $data = array();
            foreach($users as $val){
                $i++;

                $jsondata = json_decode($val->product, true);

                

                $category = Category::where('id',$jsondata['category_id'])->first();
                $subcategory = SubCategory::where('id',$jsondata['subcategory_id'])->first();
                $brand = Brand::where('id',$jsondata['brand_id'])->first();
                $branch = Branch::where('id',$val->branch_id)->first();

                $imagepath = $jsondata['image']
                ? asset('uploads/product/' . $jsondata['image']) 
                : asset('images/logo.png');


                $uimage = '<img class="status-img" src="' . $imagepath .'" alt="'.$jsondata['image'].'" style="width:40px;">';

                
                if($val->status == 'pending'){
                    $status = '<button class="btn btn-warning btn-sm">Pending</button>';
                }else if($val->status == 'approved'){
                    $status = '<button class="btn btn-success btn-sm">Approved</button>';
                }else{
                    $status = '<button class="btn btn-danger btn-sm">Rejected</button>';
                }

              
                 $action = ' <a class="btn btn-link mybtn" href="' . route('admin.product_request_view', $val->id) .'" style="color:green!important;">
                                <i class="fa fa-eye" style="color:#007bff!important;" title="View"></i>
                            </a>';
               
                $sub_array = [];
                $sub_array['no'] = $i;
                $sub_array['category'] = $category->name ?? '';
                $sub_array['subcategory'] = $subcategory->name ?? '';
                $sub_array['brand'] = $brand->name ?? '';
                $sub_array['branch'] = $branch->address.', '.$branch->city.', '.$branch->state;
                $sub_array['name'] = $jsondata['name'];
                $sub_array['image'] = $uimage;
                $sub_array['price'] = $jsondata['price'];
                $sub_array['status'] = $status;
                $sub_array['action'] = $action;
                $data[] = $sub_array;
            }


            return response()->json([
                'draw' => $request->get('draw'),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);
        }
    }

    public function product_request_view($id){
        $data = BranchProductRequest::where('id',$id)->first();
        $product = json_decode($data->product, true);
        $colors = json_decode($data->product_colors, true);
        $colorIds = collect($colors['colors'])->pluck('color_id')->toArray();
        $colorNames = Color::whereIn('id', $colorIds)->pluck('name')->toArray();

        $sizes = json_decode($data->product_sizes, true);
        $sizeIds = collect($sizes['size'])->pluck('size_id')->toArray();
        $sizeNames = Size::whereIn('id', $sizeIds)->pluck('name')->toArray();

        $sizecolorprice = json_decode($data->product_size_color_prices, true);
        $offer = json_decode($data->offers, true);
        $offertypename = '';
       
        $sizecolorresult = [];
        foreach ($sizecolorprice['size_color_price'] as $item) {
            $size = Size::find($item['size_id']);
            $color = Color::find($item['color_id']);

            $sizecolorresult[] = [
                'size'  => $size ? $size->name : '',
                'color' => $color ? $color->name : '',
                'price' => $item['price']
            ];
        }

        if (!empty($offer['offer']))
        {
            $offertype = OfferType::where('id',$offer['offer']['offer_type'])->first();
            if($offertype){
                $offertypename = $offertype->name;
            }
            
        }

        $category = Category::where('id',$product['category_id'])->first();
        $subcategory = SubCategory::where('id',$product['subcategory_id'])->first();
        $brand = Brand::where('id',$product['brand_id'])->first();

        $oldproduct = Product::leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->leftJoin('subcategories', 'subcategories.id', '=', 'products.subcategory_id')
            ->leftJoin('brands', 'brands.id', '=', 'products.brand_id')
            ->where('products.id',$data->product_id)
            ->select('products.*', 'categories.name as category_name', 'subcategories.name as subcategory_name', 'brands.name as brand_name')
            ->first();
        $oldproductimages =  ProductImage::where('product_id', $data->product_id)->pluck('image')->toArray();    
        $oldcolorids = ProductColor::where('product_id', $data->product_id)->pluck('color_id')->toArray();
        $oldproductcolor = Color::whereIn('id', $oldcolorids)->pluck('name')->toArray();

        $oldsizeids = ProductSize::where('product_id', $data->product_id)->pluck('size_id')->toArray();
        $oldproductsize = Size::whereIn('id', $oldsizeids)->pluck('name')->toArray();


        return view('admin.product_request_view',compact('id','data','product','category','subcategory','brand','colorNames','sizeNames','sizecolorresult','offer','offertypename','oldproduct','oldproductimages','oldproductcolor','oldproductsize'));
    }

     public function product_request_change_status(Request $request){
        $id = $request->id;
        $status = $request->status;
        
        $requestdata = BranchProductRequest::where('id',$id)->first();
        
        if($status == 'approved'){
            $productrequestdata = json_decode($requestdata->product, true);

            $productImages = json_decode($requestdata->product_images, true);
            $about = $requestdata->about;
            $colors = json_decode($requestdata->product_colors, true);
            $sizes = json_decode($requestdata->product_sizes, true);
            $sizecolorprice = json_decode($requestdata->product_size_color_prices, true);
            $offer = json_decode($requestdata->offers, true);

            if($requestdata->product_id != ''){
                $product = Product::where('id',$requestdata->product_id)->first();
            }else{
                $product = new Product;
            }
            


            
            $product->category_id  = $productrequestdata['category_id'];
            if($productrequestdata['subcategory_id']){
                $product->subcategory_id  = $productrequestdata['subcategory_id'];
                $subdata = SubCategory::where('id',$productrequestdata['subcategory_id'])->first();
                $product->gst  = $subdata->gst;
            }
            $product->brand_id = $productrequestdata['brand_id'];
            $product->name = $productrequestdata['name'];
            $product->description = $about;
            $product->disclaimer = $productrequestdata['disclaimer'];
            $product->price = $productrequestdata['price'];
            $product->image = $productrequestdata['image'];
            $product->veg_nonveg = $productrequestdata['veg_nonveg'] ?? 0;
            $product->is_fashion = $productrequestdata['is_fashion'];
            $product->is_cart_cancel_product = $productrequestdata['is_cart_cancel_product'];
            $product->save();

            ProductImage::where('product_id', $product->id)->delete();
            foreach ($productImages['images'] as $images) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $images,
                ]);
            }



            ProductColor::where('product_id', $product->id)->delete();
            if (!empty($colors['colors'])) {
                $insertColorData = [];
                foreach ($colors['colors'] as $colorval) {
                    $insertColorData[] = [
                        'product_id'  => $product->id,
                        'color_id' => $colorval['color_id'],
                    ];
                }
                ProductColor::insert($insertColorData);
            }

           
            ProductSize::where('product_id', $product->id)->delete();
            if (!empty($sizes['size'])) {
                $insertSizeData = [];
                foreach ($sizes['size'] as $size_id) {
                    $insertSizeData[] = [
                        'product_id'  => $product->id,
                        'size_id' => $size_id['size_id'],
                    ];
                }
                ProductSize::insert($insertSizeData);
            }

            ProductSizeColorPrice::where('product_id', $product->id)->delete();
            if (!empty($sizecolorprice['size_color_price'])) {
                foreach ($sizecolorprice['size_color_price'] as $variant) {
                    if (!empty($variant['size_id']) && !empty($variant['color_id']) && !empty($variant['price'])) {
                        $exists = ProductSizeColorPrice::where('product_id', $product->id)
                            ->where('size_id', $variant['size_id'])
                            ->where('color_id', $variant['color_id'])
                            ->exists();

                        if (!$exists) {
                            ProductSizeColorPrice::create([
                                'product_id' => $product->id,
                                'size_id' => $variant['size_id'],
                                'color_id' => $variant['color_id'],
                                'price' => $variant['price'],
                            ]);
                        }
                    }
                }
            }


             if($requestdata->product_id == ''){
                if($productrequestdata['is_fashion'] == '1'){
                    generate_deep_link('shoping_product',$product->id);
                }else{
                    generate_deep_link('product',$product->id);
                }

                if (!empty($offer['offer']))
                {

                    $sdate = \Carbon\Carbon::parse($offer['offer']['start_date'])->format('Y-m-d');
                    $edate = \Carbon\Carbon::parse($offer['offer']['end_date'])->format('Y-m-d');

                    $newoffer = new Offer;
                    $newoffer->offer_type = $offer['offer']['offer_type'];
                    $newoffer->product_id = $product->id;
                    $newoffer->title = $offer['offer']['title'];
                    $newoffer->description = $offer['offer']['description'];
                    if($offer['offer']['discount_type']){
                        $newoffer->discount_type = $offer['offer']['discount_type'];
                    }
                    if($offer['offer']['discount_value']){
                        $newoffer->discount_value = $offer['offer']['discount_value'];
                    }
                    $newoffer->start_date = $sdate;
                    $newoffer->end_date = $edate;
                    $newoffer->save();

                    $ob = new OfferBranch;
                    $ob->brand_id = $requestdata->brand_id;
                    $ob->branch_id =  $requestdata->branch_id;
                    $ob->offer_id = $newoffer->id;
                    $ob->save();
                    
                }
            }
           
           
            $requestdata->product_id = $product->id;
        }

        $requestdata->status = $status;
        $requestdata->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully!',
            'redirect' => route('admin.product_request')
        ]);
    }
}
