<?php

namespace App\Http\Controllers\Admin;

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

class BranchRequestController extends Controller
{
     public function index()
    {
        return view('admin.branch_request');
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
            $columns = ['branch_change_requests.id'];

            $query = BranchChangeRequest::join('brands', 'brands.id', '=', 'branch_change_requests.brand_id')
            ->where('branch_change_requests.status','pending')    
            ->select('branch_change_requests.*', 'brands.name as brand_name');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('branch_change_requests.branch', 'like', "%{$search}%")
                    ->orWhere('brands.name', 'like', "%{$search}%");
                });
            }
        
            $query = $query->orderBy($columns[$orderColumn], $orderDir);


            $filtertotalget =  $query->get();
            $users = $query->skip($start)->take($length)->get();


            $totalRecords = BranchChangeRequest::where('status','pending')->count();
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

                $action = ' <a class="btn btn-link mybtn" href="' . route('admin.branch_request_view', $val->id) .'" style="color:green!important;">
                                <i class="fa fa-eye" style="color:#007bff!important;" title="View"></i>
                            </a>';

                $sub_array = [];
                $sub_array['no'] = $i;
                $sub_array['brand'] = $val->brand_name;
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

     public function branch_request_view($id){
        $data = BranchChangeRequest::where('id',$id)->first();
        $oldbranch = Branch::where('id',$data->branch_id)->first();
        $oldtime = BrandTiming::where('branch_id',$data->branch_id)->get();
        $oldmenu = BrandMenu::where('branch_id',$data->branch_id)->get();
        $oldgallery = BrandGallery::where('branch_id', $data->branch_id)->get();
        $about = $data->about;
        $branchArray = json_decode($data->branch, true);
        $branch = json_decode(json_encode($branchArray));
        $timing = json_decode($data->timing, true);
        $menus = json_decode($data->menu, true);
        $gallery = json_decode($data->gallery, true);

        return view('admin.branch_request_view',compact('id','about','branch','timing','menus','gallery','oldbranch','oldtime','oldmenu','oldgallery'));
    }

    public function branch_request_change_status(Request $request){
        $id = $request->id;
        $status = $request->status;
        
        $requestdata = BranchChangeRequest::where('id',$id)->first();
        $branchid = $requestdata->branch_id;

        if($status == 'approved'){
            $requestbranchArray = json_decode($requestdata->branch, true);
            $requestbranchdata = json_decode(json_encode($requestbranchArray));
            $timing = json_decode($requestdata->timing, true);
            $menus = json_decode($requestdata->menu, true);
            $gallery = json_decode($requestdata->gallery, true);


            $branch = Branch::findOrFail($branchid);
            $branch->update([
                'state' => $requestbranchdata->state,
                'city' => $requestbranchdata->city,
                'area' => $requestbranchdata->area,
                'pincode' => $requestbranchdata->pincode,
                'address' => $requestbranchdata->address,
                'latitude' => $requestbranchdata->latitude,
                'longitude' => $requestbranchdata->longitude,
                'is_booking'=>$requestbranchdata->is_booking,
                'is_appointment'=>$requestbranchdata->is_appointment,
                'facebook' => $requestbranchdata->facebook,
                'twitter' => $requestbranchdata->twitter,
                'instagram' => $requestbranchdata->instagram,
                'linkedin' => $requestbranchdata->linkedin,
                'pinterest' => $requestbranchdata->pinterest,
            ]);

            foreach ($timing as $day => $t) {
                    BrandTiming::updateOrCreate(
                        [
                            'brand_id'  => $branch->brand_id,
                            'branch_id' => $branchid,
                            'day'       => $day
                        ],
                        [
                            'open_time'  =>  $t['open_time'],
                            'close_time' =>  $t['close_time'],
                            'status'     => $t['status']
                        ]
                    );

            }

            if(!empty($menus['images'])){
                BrandMenu::where('branch_id', $branchid)->delete();
                foreach ($menus['images'] as $img) {
                        BrandMenu::insert([
                            'brand_id'  => $branch->brand_id,
                            'branch_id' => $branchid ?? null,
                            'image'     => $img,
                            'created_at'=> now(),
                            'updated_at'=> now(),
                        ]);
                }
            }
            

            if(!empty($gallery['images'])){
                BrandGallery::where('branch_id', $branchid)->delete();
                foreach ($gallery['images'] as $gimg) {
                        BrandGallery::insert([
                            'brand_id'  => $branch->brand_id,
                            'branch_id' => $branchid ?? null,
                            'image'     => $gimg,
                            'created_at'=> now(),
                            'updated_at'=> now(),
                        ]);
                }
            }

            BranchChangeRequest::where('branch_id',$branchid)->delete();
            
        }

        $requestdata->status = $status;
        $requestdata->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully!',
            'redirect' => route('admin.branch_request')
        ]);
    }
}
