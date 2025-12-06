<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

class ProductController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('brand')->user();
        return view('brand.product');
    }

    public function get_list(Request $request)
    {
        $admin = Auth::guard('brand')->user();
        if ($request->ajax()) 
        {
            $start = $request->get('start', 0);
            $length = $request->get('length', 10); 
            $orderColumn = $request->input('order_column');
            $orderDir = $request->input('order_dir', 'asc');
            $search = $request->get('search')['value'];
            $columns = ['id'];

            $query = BranchProductRequest::where('branch_id',$admin->id);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('product', 'like', "%{$search}%");
                });
            }
        
            $query = $query->orderBy($columns[$orderColumn], $orderDir);


            $filtertotalget =  $query->get();
            $users = $query->skip($start)->take($length)->get();


            $totalRecords = BranchProductRequest::where('branch_id',$admin->id)->count();
            $filteredRecords = count($filtertotalget);

        
            $i =  $request->get('start');
            $data = array();
            foreach($users as $val){
                $i++;

                $jsondata = json_decode($val->product, true);

                

                $category = Category::where('id',$jsondata['category_id'])->first();
                $subcategory = SubCategory::where('id',$jsondata['subcategory_id'])->first();
                $brand = Brand::where('id',$jsondata['brand_id'])->first();

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

                 $action = '<a class="btn btn-link mybtn" href="' . route('brand.product_edit', $val->id) .'" style="color:green!important;">
                            <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                            </a>';

               
                $sub_array = [];
                $sub_array['no'] = $i;
                $sub_array['category'] = $category->name ?? '';
                $sub_array['subcategory'] = $subcategory->name ?? '';
                $sub_array['brand'] = $brand->name ?? '';
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

     public function add_product(){
        $admin = Auth::guard('brand')->user();

        $category = Category::
        Join('brands', 'categories.id', '=', 'brands.category_id')
        ->Join('branches', 'branches.brand_id', '=', 'brands.id')
        ->where('branches.id',$admin->id)
        ->where('categories.name','!=','All')
        ->where('categories.status','1')
        ->orderBy('categories.rank', 'asc')
        ->select('categories.*')
        ->get();

        $subcategories = SubCategory::
         Join('brands', 'subcategories.id', '=', 'brands.subcategory_id')
        ->Join('branches', 'branches.brand_id', '=', 'brands.id')
        ->where('branches.id',$admin->id)
        ->where('subcategories.status','1')
        ->orderBy('subcategories.rank', 'asc')
        ->select('subcategories.*')
        ->get();

        $brand = Brand::
         Join('branches', 'brands.id', '=', 'branches.brand_id')
         ->where('branches.id',$admin->id)
         ->get();

        $color = Color::where('status','1')->get();
        $size = Size::where('status','1')->get();
        $ot = OfferType::where('status','1')->get();
        return view('brand.add_product',compact('category','subcategories','brand','color','size','ot'));
    }

    public function insert_product(Request $request){
        $admin = Auth::guard('brand')->user();
        $branchemaildata = Branch::where('id',$admin->id)->first();

        $fileName = '';
        $productimages = [];
        $colorData = [];
        $sizeData = [];
        $sizeColorPriceData = [];
        $OfferData = [];
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/product'), $fileName);
        }

        $gst = 0;
        if($request->subcategory_id){
            $subdata = SubCategory::where('id',$request->subcategory_id)->first();
            $gst  = $subdata->gst;
        }

        $ProductData = [
            'category_id'   => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id'           => $request->brand,
            'name'        => $request->name,
            'description'        => $request->description,
            'disclaimer'       => $request->disclaimer,
            'price'      => $request->price,
            'gst'      => $gst,
            'image'       => $fileName,
            'veg_nonveg'        => $request->veg_nonveg ?? 0,
            'is_fashion'      => $request->is_fashion,
            'is_cart_cancel_product'      => $request->is_cart_cancel_product ?? 1,
        ];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $productfilename = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/product'), $productfilename);
                $productimages[] = $productfilename; 
            }
        }

        if (!empty($request->color)) {
            foreach ($request->color as $color_id) {
                $colorData[] = [
                    'color_id' => $color_id,
                ];
            }
        }

         if (!empty($request->size)) {
            foreach ($request->size as $size_id) {
                $sizeData[] = [
                    'size_id' => $size_id,
                ];
            }
        }

         if (!empty($request->variant)) {
            foreach ($request->variant as $variant) {
                if (!empty($variant['size_id']) && !empty($variant['color_id']) && !empty($variant['price'])) {
                       $sizeColorPriceData[] = $variant; 
                    
                }
            }
        }

         if($request->title){
            $sdate = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
            $edate = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');

            $OfferData = [
                'offer_type'   => $request->offer_type,
                'title' =>  $request->title,
                'description'        => $request->offerdescription,
                'discount_type'       => $request->discount_type ?? null,
                'discount_value'      => $request->discount_value ?? null,
                'start_date'        => $sdate,
                'end_date'      => $edate,
            ];
        }


        BranchProductRequest::create([
            'brand_id' =>  $request->brand,
            'branch_id' => $admin->id,
            'about' => $request->description,
            'product' => json_encode($ProductData),
            'product_images' => json_encode(['images' => $productimages]),
            'product_colors' => json_encode(['colors' => $colorData]),
            'product_sizes' => json_encode(['size' => $sizeData]),
            'product_size_color_prices' =>json_encode(['size_color_price' => $sizeColorPriceData]),
            'offers'=>json_encode(['offer' => $OfferData]),
            'status'=>'pending'
        ]);


        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('brand.product'),
        ]);
    }

    public function product_edit($id){
        $admin = Auth::guard('brand')->user();

        $category = Category::
        Join('brands', 'categories.id', '=', 'brands.category_id')
        ->Join('branches', 'branches.brand_id', '=', 'brands.id')
        ->where('branches.id',$admin->id)
        ->where('categories.name','!=','All')
        ->where('categories.status','1')
        ->orderBy('categories.rank', 'asc')
        ->select('categories.*')
        ->get();

        $subcategories = SubCategory::
         Join('brands', 'subcategories.id', '=', 'brands.subcategory_id')
        ->Join('branches', 'branches.brand_id', '=', 'brands.id')
        ->where('branches.id',$admin->id)
        ->where('subcategories.status','1')
        ->orderBy('subcategories.rank', 'asc')
        ->select('subcategories.*')
        ->get();

        $brand = Brand::
         Join('branches', 'brands.id', '=', 'branches.brand_id')
         ->where('branches.id',$admin->id)
         ->get();

        $color = Color::where('status','1')->get();
        $size = Size::where('status','1')->get();
        $ot = OfferType::where('status','1')->get();

        $editdata = BranchProductRequest::where('id',$id)->first();
        $editabout = $editdata->about;
        $editproduct = json_decode($editdata->product, true);
        $editcolors = json_decode($editdata->product_colors, true);
        $editsizes = json_decode($editdata->product_sizes, true);
        $editproductimages = json_decode($editdata->product_images, true);



        $sizecolorprice = json_decode($editdata->product_size_color_prices, true);
        $sizecolorresult = [];
        foreach ($sizecolorprice['size_color_price'] as $item) {
            $sizedata = Size::find($item['size_id']);
            $colordata = Color::find($item['color_id']);

            $sizecolorresult[] = [
                'size'  => $sizedata ? $sizedata->name : '',
                'size_id'  => $sizedata ? $sizedata->id : '0',
                'color' => $colordata ? $colordata->name : '',
                'color_id'  => $colordata ? $colordata->id : '0',
                'price' => $item['price']
            ];
        }


        return view('brand.edit_product',compact('id','category','subcategories','brand','color','size','ot','editdata','editabout','editproduct','editcolors','editsizes','editproductimages','sizecolorresult'));
    }

    public function update_product(Request $request){
       
        $old_product_images = $request->old_product_images ?? [];
        $productimages = [];
        $colorData = [];
        $sizeData = [];
        $OldSizeColorPriceData = [];
        $NewSizeColorPriceData = [];

        $admin = Auth::guard('brand')->user();
        $id = $request->id;
        $productRequest = BranchProductRequest::where('id', $id)->first();
        $editproduct = json_decode($productRequest->product, true);
        
        $fileName = $editproduct['image'];
        $gst = $editproduct['gst'];


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/product'), $fileName);
        }

        if($request->subcategory_id){
            $subdata = SubCategory::where('id',$request->subcategory_id)->first();
            $gst  = $subdata->gst;
        }

        $ProductData = [
            'category_id'   => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id'           => $request->brand,
            'name'        => $request->name,
            'description'        => $request->description,
            'disclaimer'       => $request->disclaimer,
            'price'      => $request->price,
            'gst'      => $gst,
            'image'       => $fileName,
            'veg_nonveg'        => $request->veg_nonveg ?? 0,
            'is_fashion'      => $request->is_fashion,
            'is_cart_cancel_product'      => $request->is_cart_cancel_product ?? 1,
        ];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $productfilename = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/product'), $productfilename);
                $productimages[] = $productfilename; 
            }
        }

         if (!empty($request->color)) {
            foreach ($request->color as $color_id) {
                $colorData[] = [
                    'color_id' => $color_id,
                ];
            }
        }

        if (!empty($request->size)) {
            foreach ($request->size as $size_id) {
                $sizeData[] = [
                    'size_id' => $size_id,
                ];
            }
        }

        if (!empty($request->oldvariant)) {
            foreach ($request->oldvariant as $variantoldval) {
                if (!empty($variantoldval['size_id']) && !empty($variantoldval['color_id']) && !empty($variantoldval['price'])) {
                       $OldSizeColorPriceData[] = $variantoldval; 
                    
                }
            }
        }

        if (!empty($request->variant)) {
            foreach ($request->variant as $variant) {
                if (!empty($variant['size_id']) && !empty($variant['color_id']) && !empty($variant['price'])) {
                       $NewSizeColorPriceData[] = $variant; 
                    
                }
            }
        }

       
        $new_product_images = array_merge($old_product_images, $productimages);
        $sizeColorPriceData = array_merge($OldSizeColorPriceData, $NewSizeColorPriceData);
         if ($productRequest) {
            $productRequest->update([
                'brand_id' =>  $request->brand,
                'about' => $request->description,
                'product' => json_encode($ProductData),
                'product_images' => json_encode(['images' => $new_product_images]),
                'product_colors' => json_encode(['colors' => $colorData]),
                'product_sizes' => json_encode(['size' => $sizeData]),
                'product_size_color_prices' =>json_encode(['size_color_price' => $sizeColorPriceData]),
                'status'=>'pending'
            ]);
        }
        

        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('brand.product'),
        ]);
    }


}
