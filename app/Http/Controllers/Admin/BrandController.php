<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\BrandMenu;
use App\Models\Branch;
use App\Models\BrandBanner;
use App\Models\BrandView;
use App\Models\BrandGallery;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class BrandController extends Controller
{
    public function index()
    {
        return view('admin.brand');
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
        $columns = ['brands.id', 'categories.name', 'subcategories.name', 'brands.name'];

        $query = Brand::join('categories', 'categories.id', '=', 'brands.category_id')
            ->leftJoin('subcategories', 'subcategories.id', '=', 'brands.subcategory_id')
            ->select('brands.*', 'categories.name as category_name', 'subcategories.name as subcategory_name');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('brands.name', 'like', "%{$search}%")
                ->orWhere('categories.name', 'like', "%{$search}%")
                ->orWhere('subcategories.name', 'like', "%{$search}%");
            });
        }
       
        $query = $query->orderBy($columns[$orderColumn], $orderDir);


        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = Brand::count();
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

           $is_promote_checked = '';
           if($val->is_promote == 1){
               $is_promote_checked = 'checked';
           }

           $is_promote_status = '<label class="switch"><input type="checkbox" '.$is_promote_checked.' onchange="change_promote_status('.$val->id.')"><span class="slider"></span></label>';



           $imagepath = $val->icon 
           ? asset('uploads/brand/' . $val->icon) 
           : asset('images/logo.png');


            $uimage = '<img class="status-img" src="' . $imagepath .'" alt="'.$val->icon.'" style="width:40px;">';


            $action = '
            <a class="btn btn-link mybtn" href="' . route('admin.brand_view', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-eye" style="color:#007bff!important;" title="View"></i>
                        </a>

               <a class="btn btn-link mybtn" href="' . route('admin.brand_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
            <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['category'] = $val->category_name ?? '';
            $sub_array['subcategory'] = $val->subcategory_name ?? '';
            $sub_array['name'] = $val->name;
            $sub_array['icon'] = $uimage;
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

    public function brand_view($id){
        $brand = Brand::where('id',$id)->first();
        $branch = Branch::where('brand_id',$id)->get();
        $menu = BrandMenu::where('brand_id',$id)->whereNull('branch_id')->get();
        $banner = BrandBanner::where('brand_id',$id)->orderBy('id', 'desc')->get();
        $total_view = BrandView::totalCount($id);
    
        return view('admin.view_brand',compact('brand','branch','menu','banner','total_view'));
    }

    public function add_brand(){
        $category = Category::where('name','!=','All')->where('status','1')->orderBy('rank', 'asc')->get();
        return view('admin.add_brand',compact('category'));
    }

    public function insert_brand(Request $request){

        $branddata = Brand::where('name',$request->name)->first();
        if($branddata){
             return response()->json([
                'status' => 'error',
                'message' => 'Brand already added',
            ]);
        }

       
        $fileName = '';
        $BannerfileName = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/brand'), $fileName);
        }

        if ($request->hasFile('banner_image')) {
            $bannerfile = $request->file('banner_image');
            $BannerfileName = time() . '-' . $bannerfile->getClientOriginalName();
            $bannerfile->move(public_path('uploads/brand'), $BannerfileName);
        }

        $brand = new Brand;
        $brand->category_id  = $request->category_id;
        if($request->subcategory_id){
            $brand->subcategory_id  = $request->subcategory_id;
        }
        $brand->name = $request->name;
        $brand->icon = $fileName;
        $brand->banner_image = $BannerfileName;
        $brand->description = $request->description;
        $brand->website = $request->website;
        $brand->veg_nonveg = $request->veg_nonveg ?? 0;
        $brand->save();


        generate_deep_link('brand',$brand->id);


        if ($request->hasFile('menus')) {
            foreach ($request->file('menus') as $file) {
                $filename = 'menu_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/brand'), $filename);

                BrandMenu::create([
                    'brand_id' => $brand->id,
                    'image' => $filename,
                ]);
            }
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $fileval) {
                $filenameval = 'gallery_'.time().'_'.uniqid().'.'.$fileval->getClientOriginalExtension();
                $fileval->move(public_path('uploads/brand'), $filenameval);

                BrandGallery::create([
                    'brand_id' => $brand->id,
                    'image' => $filenameval,
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.brand'),
        ]);
    }

    public function brand_edit($id){
        $brand = Brand::where('id',$id)->first();
        $category = Category::where('name','!=','All')->where('status','1')->orderBy('rank', 'asc')->get();
        $subcategory = SubCategory::where('category_id',$brand->category_id)->where('name','!=','All')->where('status','1')->orderBy('rank', 'asc')->get();
        $menus = BrandMenu::where('brand_id',$id)->whereNull('branch_id')->get();
        $gallery = BrandGallery::where('brand_id',$id)->whereNull('branch_id')->get();
        return view('admin.edit_brand',compact('brand','category','subcategory','menus','gallery'));
    }

    public function update_brand(Request $request){

        $brand = Brand::find($request->id);


        $branddata = Brand::where('name',$request->name)->where('id','!=',$request->id)->first();
        if($branddata){
             return response()->json([
                'status' => 'error',
                'message' => 'Brand already added',
            ]);
        }



        if ($request->hasFile('image')) {
            $filePath = public_path('uploads/brand/'.$brand->icon);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/brand'), $fileName);
            $brand->icon = $fileName;
        }

        if ($request->hasFile('banner_image')) {
            $filePath = public_path('uploads/brand/'.$brand->banner_image);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $banner_image_file = $request->file('banner_image');
            $banner_image_file_name = time() . '-' . $banner_image_file->getClientOriginalName();
            $banner_image_file->move(public_path('uploads/brand'), $banner_image_file_name);
            $brand->banner_image = $banner_image_file_name;
        }


        $brand->category_id  = $request->category_id;
        $brand->subcategory_id  = $request->subcategory_id;
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->website = $request->website;
        $brand->veg_nonveg = $request->veg_nonveg ?? 0;
        $brand->save();


         if ($request->hasFile('menus')) {
            foreach ($request->file('menus') as $file) {
                $filename = 'menu_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/brand'), $filename);

                BrandMenu::create([
                    'brand_id' => $request->id,
                    'image' => $filename,
                ]);
            }
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $fileval) {
                $filenameval = 'gallery_'.time().'_'.uniqid().'.'.$fileval->getClientOriginalExtension();
                $fileval->move(public_path('uploads/brand'), $filenameval);

                BrandGallery::create([
                    'brand_id' => $request->id,
                    'image' => $filenameval,
                ]);
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.brand'),
        ]);
    }


    public function brand_status_change(Request $request){
        $userdata = Brand::find($request->id);

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

    public function change_promote_status(Request $request){
        $userdata = Brand::find($request->id);

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

    public function brand_delete(Request $request){
        $userdata = Brand::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }

     public function menu_delete(Request $request){
        $userdata = BrandMenu::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }

    public function brand_gallery_delete(Request $request){
        $userdata = BrandGallery::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }

    public function get_subcategory(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->id)
            ->where('status', '1')
            ->select('id', 'name')
            ->get();

        if ($subcategories->count() > 0) {
            return response()->json(['status' => 'success', 'data' => $subcategories]);
        } else {
            return response()->json(['status' => 'error', 'data' => []]);
        }
    }

}
