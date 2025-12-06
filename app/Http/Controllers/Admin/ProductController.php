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
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product');
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
        $columns = ['products.id', 'categories.name', 'subcategories.name', 'brands.name', 'products.name','products.image','products.price'];

        $query = Product::leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->leftJoin('subcategories', 'subcategories.id', '=', 'products.subcategory_id')
            ->leftJoin('brands', 'brands.id', '=', 'products.brand_id')
            ->select('products.*', 'categories.name as category_name', 'subcategories.name as subcategory_name', 'brands.name as brand_name');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('brands.name', 'like', "%{$search}%")
                ->orWhere('categories.name', 'like', "%{$search}%")
                ->orWhere('subcategories.name', 'like', "%{$search}%")
                ->orWhere('products.name', 'like', "%{$search}%")
                ->orWhere('products.price', 'like', "%{$search}%");
            });
        }
       
        $query = $query->orderBy($columns[$orderColumn], $orderDir);


        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = Product::count();
        $filteredRecords = count($filtertotalget);

       
        $i =  $request->get('start');
        $data = array();
        foreach($users as $val){
           $i++;



            $is_promote_checked = '';
           if($val->is_promote == 1){
               $is_promote_checked = 'checked';
           }

           $is_promote_status = '<label class="switch"><input type="checkbox" '.$is_promote_checked.' onchange="change_promote_status('.$val->id.')"><span class="slider"></span></label>';



           $checked = '';
           if($val->status == 1){
               $checked = 'checked';
           }

            $status = '<label class="switch"><input type="checkbox" '.$checked.' onchange="changestatus('.$val->id.')"><span class="slider"></span></label>';



           $imagepath = $val->image 
           ? asset('uploads/product/' . $val->image) 
           : asset('images/logo.png');


            $uimage = '<img class="status-img" src="' . $imagepath .'" alt="'.$val->icon.'" style="width:40px;">';


            $action = '
                <a class="btn btn-link mybtn" href="' . route('admin.product_view', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-eye" style="color:#007bff!important;" title="View"></i>
                        </a>


               <a class="btn btn-link mybtn" href="' . route('admin.product_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
            <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['category'] = $val->category_name ?? '';
            $sub_array['subcategory'] = $val->subcategory_name ?? '';
            $sub_array['brand'] = $val->brand_name ?? '';
            $sub_array['name'] = $val->name;
            $sub_array['image'] = $uimage;
            $sub_array['price'] = $val->price;
            $sub_array['is_promote'] = $is_promote_status;
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
        $category = Category::where('name','!=','All')->where('status','1')->orderBy('rank', 'asc')->get();
        $color = Color::where('status','1')->get();
        $size = Size::where('status','1')->get();
        $ot = OfferType::where('status','1')->get();
        return view('admin.add_product',compact('category','color','size','ot'));
    }

    public function new_product_insert(Request $request){

        $productdata = Product::where('name',$request->name)->first();
        if($productdata){
             return response()->json([
                'status' => 'error',
                'message' => 'Product already added',
            ]);
        }

        
        $fileName = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/product'), $fileName);
        }


        $product = new Product;
        $product->category_id  = $request->category_id;
        if($request->subcategory_id){
            $product->subcategory_id  = $request->subcategory_id;
            $subdata = SubCategory::where('id',$request->subcategory_id)->first();
            $product->gst  = $subdata->gst;
        }
        $product->brand_id = $request->brand;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->disclaimer = $request->disclaimer;
        $product->price = $request->price;
        $product->image = $fileName;
        $product->veg_nonveg = $request->veg_nonveg ?? 0;
        $product->is_fashion = $request->is_fashion;
        $product->is_cart_cancel_product = $request->is_cart_cancel_product;
        $product->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/product'), $filename);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $filename,
                ]);
            }
        }
        
        if($request->is_fashion == '1'){
            generate_deep_link('shoping_product',$product->id);
        }else{
            generate_deep_link('product',$product->id);
        }
        


        if (!empty($request->color)) {
            $insertData = [];
            foreach ($request->color as $color_id) {
                $insertData[] = [
                    'product_id'  => $product->id,
                    'color_id' => $color_id,
                ];
            }
            ProductColor::insert($insertData);
        }


        if (!empty($request->size)) {
            $insertData2 = [];
            foreach ($request->size as $size_id) {
                $insertData2[] = [
                    'product_id'  => $product->id,
                    'size_id' => $size_id,
                ];
            }
            ProductSize::insert($insertData2);
        }



        if (!empty($request->variant)) {
            foreach ($request->variant as $variant) {
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


        if($request->title){
            $branch = $request->branch;
            $sdate = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
            $edate = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');

            $offer = new Offer;
            $offer->offer_type = $request->offer_type;
            $offer->product_id = $product->id;
            $offer->title = $request->title;
            $offer->description = $request->offerdescription;
            if($request->discount_type){
                $offer->discount_type = $request->discount_type;
            }
            if($request->discount_value){
                $offer->discount_value = $request->discount_value;
            }
            $offer->start_date = $sdate;
            $offer->end_date = $edate;
            $offer->save();

            if($branch){
                foreach($branch as $val){
                    $ob = new OfferBranch;
                    $ob->brand_id = $request->brand;
                    $ob->branch_id = $val;
                    $ob->offer_id = $offer->id;
                    $ob->save();
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.product'),
        ]);
    }

    
    public function product_view($id){
        $product = Product::where('id',$id)->first();
        $product_image = ProductImage::where('product_id',$id)->get();

        $product_review = ProductRating::with('user:id,first_name,last_name,image')
                ->where('product_id', $id)
                ->orderByDesc('id')
                ->take(20)
                ->get();
    
        return view('admin.view_product',compact('product','product_image','product_review'));
    }

    public function product_edit($id){
        $product = Product::where('id',$id)->first();
        $product_image = ProductImage::where('product_id',$id)->get();
        $category = Category::where('name','!=','All')->where('status','1')->orderBy('rank', 'asc')->get();
        $subcategory = SubCategory::where('category_id',$product->category_id)->where('name','!=','All')->where('status','1')->orderBy('rank', 'asc')->get();
        
        $brand = Brand::where('status', '1')->where('category_id',$product->category_id)
            ->select('id', 'name');
        if($product->subcategory_id){
            $brand = $brand->where('subcategory_id',$product->subcategory_id);
        }
        $brand = $brand->get();
        
        
        $color = Color::where('status','1')->get();
        $size = Size::where('status','1')->get();
        $pc = ProductColor::where('product_id', $id)->pluck('color_id')->toArray();
        $ps = ProductSize::where('product_id', $id)->pluck('size_id')->toArray();


         $variants = ProductSizeColorPrice::where('product_id', $id)
        ->with(['size', 'color'])
        ->get();


        return view('admin.edit_product',compact('category','product','product_image','subcategory','brand','size','color','pc','ps','variants'));
    }

    public function update_product(Request $request){
        $product = Product::where('id',$request->id)->first();

        $productdata = Product::where('name',$request->name)->where('id','!=',$request->id)->first();
        if($productdata){
             return response()->json([
                'status' => 'error',
                'message' => 'Product already added',
            ]);
        }


        if ($request->hasFile('image')) {

            $filePath = public_path('uploads/product/'.$product->image);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/product'), $fileName);
            $product->image = $fileName;
        }


        
        $product->category_id  = $request->category_id;
       if($request->subcategory_id){
            $product->subcategory_id  = $request->subcategory_id;
            $subdata = SubCategory::where('id',$request->subcategory_id)->first();
            $product->gst  = $subdata->gst;
        }
        $product->brand_id = $request->brand;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->disclaimer = $request->disclaimer;
        $product->price = $request->price;
        $product->veg_nonveg = $request->veg_nonveg ?? 0;
        $product->is_fashion = $request->is_fashion;
        $product->is_cart_cancel_product = $request->is_cart_cancel_product;
       
        $product->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/product'), $filename);

                ProductImage::create([
                    'product_id' => $request->id,
                    'image' => $filename,
                ]);
            }
        }



        ProductColor::where('product_id', $request->id)->delete();
        if (!empty($request->color)) {
            $insertData = [];
            foreach ($request->color as $color_id) {
                $insertData[] = [
                    'product_id'  => $request->id,
                    'color_id' => $color_id,
                ];
            }
            ProductColor::insert($insertData);
        }


        ProductSize::where('product_id', $request->id)->delete();
        if (!empty($request->size)) {
            $insertData2 = [];
            foreach ($request->size as $size_id) {
                $insertData2[] = [
                    'product_id'  => $request->id,
                    'size_id' => $size_id,
                ];
            }
            ProductSize::insert($insertData2);
        }
        

        ProductSizeColorPrice::where('product_id', $product->id)->delete();

         if (!empty($request->variant)) {
            foreach ($request->variant as $variant) {
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
        


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.product'),
        ]);
    }

    public function product_status_change(Request $request){
        $userdata = Product::find($request->id);

        if($userdata['status'] == '0'){
            $userdata->status = '1';
        }else{
            $userdata->status = '0';
        }
        
         $userdata->save();

         return response()->json([
            'status' => 'success',
            'msg' => 'status change success',
        ]);
    }

    public function change_product_promote_status(Request $request){
        $userdata = Product::find($request->id);

        if($userdata['is_promote'] == '0'){
            $userdata->is_promote = '1';
        }else{
            $userdata->is_promote = '0';
        }
        
         $userdata->save();

         return response()->json([
            'status' => 'success',
            'msg' => 'status change success',
        ]);
    }


    public function product_delete(Request $request){
        $userdata = Product::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }

     public function product_image_delete(Request $request){
        $userdata = ProductImage::find($request->id);

        $filePath = public_path('uploads/product/'.$userdata->image);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }


        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }

      public function product_price_delete(Request $request){
        $userdata = ProductSizeColorPrice::find($request->id);

        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }

    public function get_brand(Request $request)
    {
        $brand = Brand::where('status', '1')
            ->select('id', 'name');
        
        if($request->category_id){
            $brand = $brand->where('category_id',$request->category_id);
        }

        if($request->subcategory_id){
            $brand = $brand->where('subcategory_id',$request->subcategory_id);
        }

        $brand = $brand->get();

        if ($brand->count() > 0) {
            return response()->json(['status' => 'success', 'data' => $brand]);
        } else {
            return response()->json(['status' => 'error', 'data' => []]);
        }
    }
}
