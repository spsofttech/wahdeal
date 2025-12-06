<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OfferType;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Branch;
use App\Models\OfferBranch;
use Carbon\Carbon;

class OfferController extends Controller
{
    public function index() 
    {
        return view('admin.offer');
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
        $columns = ['offers.id','offer_types.name','products.name','offers.title','offers.description','offers.discount_type','offers.discount_value','offers.start_date','offers.end_date'];

         $query = Offer::leftJoin('offer_types', 'offer_types.id', '=', 'offers.offer_type')
            ->Join('products', 'products.id', '=', 'offers.product_id')
            ->select('offers.*', 'products.name as product_name', 'offer_types.name as offer_types_name');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('offer_types.name', 'like', "%{$search}%")
                ->orWhere('products.name', 'like', "%{$search}%")
                ->orWhere('offers.title', 'like', "%{$search}%")
                ->orWhere('offers.description', 'like', "%{$search}%")
                ->orWhere('offers.discount_type', 'like', "%{$search}%")
                ->orWhere('offers.discount_value', 'like', "%{$search}%");
            });
        }
       
        $query = $query->orderBy($columns[$orderColumn], $orderDir);


        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = Offer::count();
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
               <a class="btn btn-link mybtn" href="' . route('admin.offer_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
            <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['offer_type'] = $val->offer_types_name;
            $sub_array['product'] = $val->product_name;
            $sub_array['title'] = $val->title;
            $sub_array['discription'] = str_word_count(strip_tags($val->description), 1) > 10
    ? implode(' ', array_slice(explode(' ', strip_tags($val->description)), 0, 10)) . '...'
    : strip_tags($val->description);
            $sub_array['discount_type'] = $val->discount_type;
            $sub_array['discount'] = $val->discount_value;
            $sub_array['start_date'] = Carbon::parse($val->start_date)->format('d, M Y');
            $sub_array['end_date'] = Carbon::parse($val->end_date)->format('d, M Y');
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

    public function add_offer(){
        $ot = OfferType::where('status','1')->get();
        $product = Product::where('status','1')->get();
        return view('admin.add_offer',compact('ot','product'));
    }

    public function insert_offer(Request $request){

        $branch = $request->branch;
        $sdate = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
        $edate = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');

        $product = Product::where('id',$request->product_id)->first();

        $offer = new Offer;
        $offer->offer_type = $request->offer_type;
        $offer->product_id = $request->product_id;
        $offer->title = $request->title;
        $offer->description = $request->description;
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
                $ob->brand_id = $product->brand_id;
                $ob->branch_id = $val;
                $ob->offer_id = $offer->id;
                $ob->save();
            }
        }
        


        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.offer'),
        ]);
    }

    public function offer_edit($id){
        $offer = Offer::where('id',$id)->first();
        $ot = OfferType::where('status','1')->get();
        $product = Product::where('status','1')->get();

        $p = Product::where('id',$offer->product_id)->first();
        $branch = Branch::where('brand_id', $p->brand_id)
            ->where('status', '1')
            ->select('id', 'address', 'state', 'city', 'pincode')
            ->get();

        $ob = OfferBranch::where('offer_id', $id)->pluck('branch_id')->toArray();

        return view('admin.edit_offer',compact('offer','ot','product','branch','ob'));
    }

    public function update_offer(Request $request){

        $branch = $request->branch;
        $sdate = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
        $edate = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');

        $product = Product::where('id',$request->product_id)->first();

        $offer = Offer::where('id',$request->id)->first();
        $offer->offer_type = $request->offer_type;
        $offer->product_id = $request->product_id;
        $offer->title = $request->title;
        $offer->description = $request->description;
        $offer->discount_type = $request->discount_type;
        $offer->discount_value = $request->discount_value;
        $offer->start_date = $sdate;
        $offer->end_date = $edate;
        $offer->save();

        OfferBranch::where('offer_id', $request->id)->delete(); // remove old relations

        if (!empty($request->branch)) {
            $insertData = [];
            foreach ($request->branch as $branchId) {
                $insertData[] = [
                    'brand_id'  => $product->brand_id,
                    'branch_id' => $branchId,
                    'offer_id'  => $request->id,
                ];
            }
            OfferBranch::insert($insertData);
        }
        


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.offer'),
        ]);
    }


     public function offer_status_change(Request $request){
        $userdata = Offer::find($request->id);

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

    public function offer_delete(Request $request){
        $userdata = Offer::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }

    public function get_branch_using_product(Request $request)
    {
        $p = Product::where('id',$request->id)->first();
        $branch = Branch::where('brand_id', $p->brand_id)
            ->where('status', '1')
            ->select('id', 'address', 'state', 'city', 'pincode')
            ->get();

        if ($branch->count() > 0) {
            return response()->json(['status' => 'success', 'data' => $branch]);
        } else {
            return response()->json(['status' => 'error', 'data' => []]);
        }
    }

    public function get_branch_using_brand(Request $request)
    {
        $branch = Branch::where('brand_id', $request->id)
            ->where('status', '1')
            ->select('id', 'address', 'state', 'city', 'pincode')
            ->get();

        if ($branch->count() > 0) {
            return response()->json(['status' => 'success', 'data' => $branch]);
        } else {
            return response()->json(['status' => 'error', 'data' => []]);
        }
    }

}
