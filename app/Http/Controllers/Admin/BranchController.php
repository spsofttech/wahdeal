<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\BrandTiming;
use App\Models\BrandMenu;
use App\Models\BrandGallery;
use App\Models\Role;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Writer\PngWriter;
use Carbon\Carbon;


class BranchController extends Controller
{
    public function index()
    {
        return view('admin.branch');
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
            $columns = ['branches.id', 'brands.name', 'branches.state', 'branches.city','branches.area','branches.contact_no','branches.address'];

            $query = Branch::join('brands', 'brands.id', '=', 'branches.brand_id')
                ->select('branches.*', 'brands.name as brand_name');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('brands.name', 'like', "%{$search}%")
                    ->orWhere('branches.state', 'like', "%{$search}%")
                    ->orWhere('branches.city', 'like', "%{$search}%")
                    ->orWhere('branches.area', 'like', "%{$search}%")
                    ->orWhere('branches.contact_no', 'like', "%{$search}%")
                    ->orWhere('branches.address', 'like', "%{$search}%");
                });
            }
        
            $query = $query->orderBy($columns[$orderColumn], $orderDir);


            $filtertotalget =  $query->get();
            $users = $query->skip($start)->take($length)->get();


            $totalRecords = Branch::count();
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


                $action = '
                <a class="btn btn-link mybtn" href="' . route('admin.branch_edit', $val->id) .'" style="color:green!important;">
                            <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                            </a>
                            
                <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                            <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                            </button>';

                $sub_array = [];
                $sub_array['no'] = $i;
                $sub_array['brand'] = $val->brand_name ?? '';
                $sub_array['state'] = $val->state ?? '';
                $sub_array['city'] = $val->city;
                $sub_array['area'] = $val->area;
                $sub_array['contact_no'] =  $val->contact_no;
                $sub_array['address'] = $val->address;
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

    public function add_branch(){
        $brand = Brand::where('status','1')->get();
        return view('admin.add_branch',compact('brand'));
    }

    public function insert_branch(Request $request){

        $contactdata = Branch::where('contact_no',$request->contact)->first();
        if($contactdata){
             return response()->json([
                'status' => 'error',
                'message' => 'Contact no already added',
            ]);
        }

        if($request->whatsapp_no){
            $whatsappdata = Branch::where('whatsapp_no',$request->whatsapp_no)->first();
            if($whatsappdata){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Whatsapp no already added',
                ]);
            }
        }

        if($request->email){
            $branchemaildata = Branch::where('email',$request->email)->first();
            if($branchemaildata){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email already added',
                ]);
            }
        }
        


        $Brand = Brand::where('id',$request->brand)->first();
        $bname = $Brand->name;

        
        $branch = Branch::create([
            'brand_id' => $request->brand,
            'about' => $Brand->description ?? '',
            'email' => $request->email ?? '',
            'state' => $request->state,
            'city' => $request->city,
            'area' => $request->area,
            'pincode' => $request->pincode,
            'contact_no' => $request->contact,
            'whatsapp_no' => $request->whatsapp_no,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_booking'=>$request->is_booking,
            'is_appointment'=>$request->is_appointment,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'pinterest' => $request->pinterest,
        ]);

        $code = $bname.'_'.$Brand->id.'_'.$branch->id;

         $qrCode = Builder::create()
            ->writer(new PngWriter()) // Use PNG format
            ->data($code)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(10)
            ->labelText('Team QR Code')
            ->labelFont(new NotoSans(16))
            ->build();

            $qname = "branch_".$branch->id.".png";
            $filePath = public_path("uploads/brand/".$qname);
            $qrCode->saveToFile($filePath);

        $update['qr_code']= $qname;
        $update['qr_code_text']= $code;
        Branch::where('id',$branch->id)->update($update);

        foreach ($request->timings as $day => $data) {
            BrandTiming::create([
                'brand_id' => $request->brand,
                'branch_id' => $branch->id,
                'day' => $day,
                'open_time' => Carbon::createFromFormat('H:i', $data['open_time'])->format('g:i A'),
                'close_time' => Carbon::createFromFormat('H:i', $data['close_time'])->format('g:i A'),
                'status' => isset($data['status']) ? '1' : '0',
            ]);
        }


        $menu = BrandMenu::where('brand_id',$request->brand)->get();

        if(!empty($menu)){
            foreach($menu as $val){
                BrandMenu::create([
                    'brand_id' => $request->brand,
                    'branch_id' => $branch->id,
                    'image' => $val->image,
                ]);
            }
        }


        $gallery = BrandGallery::where('brand_id',$request->brand)->get();

        if(!empty($gallery)){
            foreach($gallery as $vals){
                BrandGallery::create([
                    'brand_id' => $request->brand,
                    'branch_id' => $branch->id,
                    'image' => $vals->image,
                ]);
            }
        }

        Role::where('branch_id', $branch->id)->delete();
        $role = array('product','branch','order');
        foreach($role as $val){
            $newrole = new Role;
            $newrole->branch_id = $branch->id;
            $newrole->role = $val;
            $newrole->save();
        }

        

        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.branch'),
        ]);
    }

    public function branch_edit($id){
        $brand = Brand::where('status','1')->get();
        $branch = Branch::where('id',$id)->first();
        $timing = BrandTiming::where('branch_id', $id)->get()->keyBy('day');
        $menus = BrandMenu::where('branch_id',$id)->get();
        $gallery = BrandGallery::where('branch_id',$id)->get();
        return view('admin.edit_branch',compact('brand','branch','timing','menus','gallery'));
    }

     public function update_branch(Request $request){

        

        $contactdata = Branch::where('contact_no',$request->contact)->where('id','!=',$request->id)->first();
        if($contactdata){
             return response()->json([
                'status' => 'error',
                'message' => 'Contact no already added',
            ]);
        }

        if($request->whatsapp_no){
            $whatsappdata = Branch::where('whatsapp_no',$request->whatsapp_no)->where('id','!=',$request->id)->first();
            if($whatsappdata){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Whatsapp no already added',
                ]);
            }
        }

        if($request->email){
            $branchemaildata = Branch::where('email',$request->email)->where('id','!=',$request->id)->first();
            if($branchemaildata){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email already added',
                ]);
            }
        }


        $branch = Branch::findOrFail($request->id);

        // 🔹 Update branch info
        $branch->update([
            'about' => $request->description,
            'state' => $request->state,
            'city' => $request->city,
            'area' => $request->area,
            'pincode' => $request->pincode,
            'contact_no' => $request->contact,
            'whatsapp_no' => $request->whatsapp_no,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_booking'=>$request->is_booking,
            'is_appointment'=>$request->is_appointment,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'pinterest' => $request->pinterest,
        ]);

        BrandTiming::where('branch_id', $request->id)->delete();

       foreach ($request->timings as $day => $data) {
            BrandTiming::create([
                'brand_id' => $branch->brand_id,
                'branch_id' => $request->id,
                'day' => $day,
                'open_time' => Carbon::createFromFormat('H:i', $data['open_time'])->format('g:i A'),
                'close_time' => Carbon::createFromFormat('H:i', $data['close_time'])->format('g:i A'),
                'status' => isset($data['status']) ? '1' : '0',
            ]);
        }


        if ($request->hasFile('menus')) {
            foreach ($request->file('menus') as $file) {
                $filename = 'menu_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/brand'), $filename);

                BrandMenu::create([
                    'brand_id' => $branch->brand_id,
                    'branch_id' => $request->id,
                    'image' => $filename,
                ]);
            }
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $fileval) {
                $filenameval = 'gallery_'.time().'_'.uniqid().'.'.$fileval->getClientOriginalExtension();
                $fileval->move(public_path('uploads/brand'), $filenameval);

                BrandGallery::create([
                    'brand_id' => $branch->brand_id,
                    'branch_id' => $request->id,
                    'image' => $filenameval,
                ]);
            }
        }

       

        return response()->json([
            'status' => 'success',
            'message' => 'Data updated successfully!',
            'redirect' => route('admin.branch')
        ]);
     }


    public function branch_status_change(Request $request){
        $userdata = Branch::find($request->id);

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

     public function branch_delete(Request $request){
        $userdata = Branch::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }
}
