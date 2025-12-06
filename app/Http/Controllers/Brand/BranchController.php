<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\BrandTiming;
use App\Models\BrandMenu;
use App\Models\BrandGallery;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Writer\PngWriter;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Models\BranchChangeRequest;

class BranchController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('brand')->user();
        $exists = BranchChangeRequest::where('branch_id',$admin->id)->first();
        if(!$exists){
            $timing = [];
            $menuimages = [];
            $galleryimages = [];
            $branchdata = Branch::where('id',$admin->id)->first();
            $timedata = BrandTiming::where('branch_id',$admin->id)->get();
            $menus = BrandMenu::where('branch_id',$admin->id)->get();
            $gallery = BrandGallery::where('branch_id',$admin->id)->get();
            $jsonData = [
                'email'          => $branchdata->email,
                'state'          => $branchdata->state,
                'city'           => $branchdata->city,
                'area'           => $branchdata->area,
                'pincode'        => $branchdata->pincode,
                'contact'        => $branchdata->contact_no,
                'whatsapp_no'        => $branchdata->whatsapp_no,
                'address'        => $branchdata->address,
                'latitude'       => $branchdata->latitude,
                'longitude'      => $branchdata->longitude,
                'facebook'       => $branchdata->facebook,
                'twitter'        => $branchdata->twitter,
                'instagram'      => $branchdata->instagram,
                'linkedin'       => $branchdata->linkedin,
                'pinterest'      => $branchdata->pinterest,
                'whatsapp_no'    => $branchdata->whatsapp_no,
                'is_booking'     => $branchdata->is_booking,
                'is_appointment' => $branchdata->is_appointment,
            ];

            foreach ($timedata as $day => $t) {
                $day = $t['day'];
                $open = trim($t['open_time']);
                $close = trim($t['close_time']);
                $timing[$day] = [
                        'open_time'  => $open,
                        'close_time' => $close,
                        'status'     => isset($t['status']) ? '1' : '0',
                    ];
            }

            if (!empty($menus)) {
                foreach ($menus as $menuimg) {
                    $menuimages[] = $menuimg->image;
                }
            }

            if (!empty($gallery)) {
                foreach ($gallery as $galleryimg) {
                    $galleryimages[] = $galleryimg->image;
                }
            }

            BranchChangeRequest::create([
                'brand_id' => $branchdata->brand_id,
                'branch_id' => $admin->id,
                'about' => $branchdata->about,
                'branch' => json_encode($jsonData),
                'timing' => json_encode($timing),
                'menu' => json_encode(['images' => $menuimages]),
                'gallery' => json_encode(['images' => $galleryimages]),
                'status' => 'approved',
            ]);
        }
        
        return view('brand.branch');
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

            $query = BranchChangeRequest::where('branch_id',$admin->id);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('branch', 'like', "%{$search}%");
                });
            }
        
            $query = $query->orderBy($columns[$orderColumn], $orderDir);


            $filtertotalget =  $query->get();
            $users = $query->skip($start)->take($length)->get();


            $totalRecords = BranchChangeRequest::where('branch_id',$admin->id)->count();
            $filteredRecords = count($filtertotalget);

        
            $i =  $request->get('start');
            $data = array();
            foreach($users as $val){
                $i++;

                $jsondata = json_decode($val->branch, true);

                
                if($val->status == 'pending'){
                    $status = '<button class="btn btn-warning btn-sm">Pending</button>';
                }else if($val->status == 'approved'){
                    $status = '<button class="btn btn-success btn-sm">Approved</button>';
                }else{
                    $status = '<button class="btn btn-danger btn-sm">Rejected</button>';
                }

                $action = '<a class="btn btn-link mybtn" href="' . route('brand.branch_edit', $val->id) .'" style="color:green!important;">
                            <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                            </a>';

               
                $sub_array = [];
                $sub_array['no'] = $i;
                $sub_array['address'] = $jsondata['address'];
                $sub_array['area'] = $jsondata['area'];
                $sub_array['state'] = $jsondata['state'];
                $sub_array['city'] = $jsondata['city'];
                $sub_array['pincode'] = $jsondata['pincode'];
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

    

    public function branch_edit($id){
        $data = BranchChangeRequest::where('id',$id)->first();
        $about = $data->about;
        $branchArray = json_decode($data->branch, true);
        $branch = json_decode(json_encode($branchArray));
        $timing = json_decode($data->timing, true);
        $menus = json_decode($data->menu, true);
        $gallery = json_decode($data->gallery, true);

        $oldbranch = Branch::where('id',$data->branch_id)->first();

        return view('brand.edit_branch',compact('id','about','branch','timing','menus','gallery','oldbranch'));
    }


    public function update_branch(Request $request){
        $admin = Auth::guard('brand')->user();
        $id = $request->id;
        $timing = [];
        $old_menu_images = $request->old_menu_images ?? [];
        $menuimages = [];
        $galleryimages = [];
        $old_gallery_images = $request->old_gallery_images ?? [];

        $jsonData = [
            'state'          => $request->state,
            'city'           => $request->city,
            'area'           => $request->area,
            'pincode'        => $request->pincode,
            'address'        => $request->address,
            'latitude'       => $request->latitude,
            'longitude'      => $request->longitude,
            'facebook'       => $request->facebook,
            'twitter'        => $request->twitter,
            'instagram'      => $request->instagram,
            'linkedin'       => $request->linkedin,
            'pinterest'      => $request->pinterest,
            'is_booking'     => $request->is_booking,
            'is_appointment' => $request->is_appointment,
        ];

        foreach ($request->timings as $day => $t) {
            $timing[$day] = [
                'open_time'  => Carbon::createFromFormat('H:i', $t['open_time'])->format('g:i A'),
                'close_time' => Carbon::createFromFormat('H:i', $t['close_time'])->format('g:i A'),
                'status'     => isset($t['status']) ? '1' : '0',
            ];
        }

        if ($request->hasFile('menus')) {
            foreach ($request->file('menus') as $file) {
                $menufilename = 'menu_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/brand'), $menufilename);
                $menuimages[] = $menufilename; 
            }
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $fileval) {
                $filenameval = 'gallery_'.time().'_'.uniqid().'.'.$fileval->getClientOriginalExtension();
                $fileval->move(public_path('uploads/brand'), $filenameval);
                $galleryimages[] = $filenameval;
            }
        }

        $new_menuimages = array_merge($old_menu_images, $menuimages);
        $new_galleryimages = array_merge($old_gallery_images, $galleryimages);
        $branchRequest = BranchChangeRequest::where('id', $id)->first();
        if ($branchRequest) {
            $branchRequest->update([
                'about' => $request->description,
                'branch' => json_encode($jsonData),
                'menu' => json_encode(['images' => $new_menuimages]),
                'gallery' => json_encode(['images' => $new_galleryimages]),
                'timing' => json_encode($timing),
                'status' => 'pending',
            ]);
        }
    

        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('brand.branch'),
        ]);
    }

    
}
