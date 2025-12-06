<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BrandBanner;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        return view('admin.banner');
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
            $columns = ['brand_banners.id', 'brands.name', 'products.name', 'brand_banners.own_banner','brand_banners.launch_type','brand_banners.type','brand_banners.website'];

            $query = BrandBanner::leftJoin('brands', 'brands.id', '=', 'brand_banners.brand_id')
                ->leftJoin('products', 'products.id', '=', 'brand_banners.product_id')
                ->select('brand_banners.*', 'brands.name as brand_name', 'products.name as product_name');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('brands.name', 'like', "%{$search}%")
                    ->orWhere('products.name', 'like', "%{$search}%")
                    ->orWhere('brand_banners.own_banner', 'like', "%{$search}%")
                    ->orWhere('brand_banners.launch_type', 'like', "%{$search}%")
                    ->orWhere('brand_banners.type', 'like', "%{$search}%")
                    ->orWhere('brand_banners.website', 'like', "%{$search}%");
                });
            }
        
            $query = $query->orderBy($columns[$orderColumn], $orderDir);


            $filtertotalget =  $query->get();
            $users = $query->skip($start)->take($length)->get();


            $totalRecords = BrandBanner::count();
            $filteredRecords = count($filtertotalget);

        
            $i =  $request->get('start');
            $data = array();
            foreach($users as $val){
            $i++;

            $checked = '';
            if($val->status == 1){
                $checked = 'checked';
            }

                $status = '<label class="switch"><input type="checkbox" '.$checked.' onchange="changestatus('.$val->id.')"><span class="slider"></span></label>';


                $imagepath = $val->image 
                ? asset('uploads/brand/' . $val->image) 
                : asset('images/logo.png');


                $uimage = '<img class="status-img" src="' . $imagepath .'" alt="'.$val->icon.'" style="width:100%;">';


                $action = '
                <a class="btn btn-link mybtn" href="' . route('admin.banner_edit', $val->id) .'" style="color:green!important;">
                            <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                            </a>
                            
                <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                            <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                            </button>';

                $sub_array = [];
                $sub_array['no'] = $i;
                $sub_array['brand'] = $val->brand_name ?? '';
                $sub_array['product'] = $val->product_name ?? '';
                $sub_array['own'] = $val->own_banner == '1' ? 'Own Banner' : 'Not Own';
                $sub_array['launchtype'] = $val->launch_type;
                $sub_array['bannertype'] =  $val->type;
                $sub_array['image'] = $uimage;
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

    public function add_banner(){
        $brand = Brand::where('status','1')->get();
        $product = Product::where('status','1')->get();
        return view('admin.add_banner',compact('brand','product'));
    }

    public function insert_banner(Request $request){
        $fileName = '';
         if ($request->hasFile('image')) {
            $bannerfile = $request->file('image');
            $fileName = time() . '-' . $bannerfile->getClientOriginalName();
            $bannerfile->move(public_path('uploads/brand'), $fileName);
        }

        BrandBanner::where('own_banner', $request->own)
                ->where('launch_type', $request->ltype)
                ->where('type', '!=', $request->btype)
                ->update(['status' => '0']);

         BrandBanner::where('own_banner', $request->own)
                ->where('launch_type', $request->ltype)
                ->where('type', '=', $request->btype)
                ->update(['status' => '1']);

        $banner = new BrandBanner;
        $banner->brand_id  = $request->brand;
        $banner->product_id  = $request->product;
        $banner->own_banner  = $request->own;
        $banner->launch_type  = $request->ltype;
        $banner->type  = $request->btype;
        $banner->image  = $fileName;
        $banner->website  = $request->website;
        $banner->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.banner'),
        ]);
    }

     public function banner_edit($id){
        $brand = Brand::where('status','1')->get();
        $product = Product::where('status','1')->get();
        $banner = BrandBanner::where('id',$id)->first();
        return view('admin.edit_banner',compact('brand','product','banner'));
    }

    public function update_banner(Request $request){

        $banner = BrandBanner::find($request->id);

        if ($request->hasFile('image')) {
            $filePath = public_path('uploads/brand/'.$banner->image);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/brand'), $fileName);
            $banner->image = $fileName;
        }


        $banner->brand_id  = $request->brand;
        $banner->product_id  = $request->product;
        $banner->own_banner  = $request->own;
        $banner->launch_type  = $request->ltype;
        $banner->type  = $request->btype;
        $banner->website  = $request->website;
        $banner->save();



        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.banner'),
        ]);
    }


    public function banner_status_change(Request $request){
        $userdata = BrandBanner::find($request->id);

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

    public function banner_delete(Request $request){
        $userdata = BrandBanner::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }

}
