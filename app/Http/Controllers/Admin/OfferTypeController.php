<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OfferType;

class OfferTypeController extends Controller
{
    public function index() 
    {
        return view('admin.offer_type');
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
        $columns = ['id','name'];

        $query = OfferType::select('*');

        if ($search) {
                $query->where(function ($q) use ($search) {
                     $q->where('name', 'like', "%{$search}%");
                });
        }
       
        $query = $query->orderBy($columns[$orderColumn], $orderDir);


        $filtertotalget =  $query->get();
        $users = $query->skip($start)->take($length)->get();


        $totalRecords = OfferType::count();
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
               <a class="btn btn-link mybtn" href="' . route('admin.offer_type_edit', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-edit" style="color:green!important;" title="Edit"></i>
                        </a>
                        
            <button class="btn btn-link mybtn" onclick="deleteuser('.$val->id.')">
                           <i class="fa fa-trash" style="color: red;" title="Delete"></i>
                        </button>';

            $sub_array = [];
            $sub_array['no'] = $i;
            $sub_array['name'] = $val->name;
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


    public function add_offer_type(){
        return view('admin.add_offer_type');
    }

    public function insert_offer_type(Request $request){

        $OfferTypedata = OfferType::where('name',$request->name)->first();
        if($OfferTypedata){
             return response()->json([
                'status' => 'error',
                'message' => 'OfferType already added',
            ]);
        }


        $offertype = new OfferType;
        $offertype->name = $request->name;
        $offertype->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Added Success',
            'redirect' => route('admin.offer_type'),
        ]);
    }

    public function offer_type_edit($id){
        $offertype = OfferType::where('id',$id)->first();
        return view('admin.edit_offer_type',compact('offertype'));
    }

     public function update_offer_type(Request $request){

        $OfferTypedata = OfferType::where('name',$request->name)->where('id','!=',$request->id)->first();
        if($OfferTypedata){
             return response()->json([
                'status' => 'error',
                'message' => 'OfferType already added',
            ]);
        }


        $offertype = OfferType::find($request->id);
        $offertype->name = $request->name;
        $offertype->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.offer_type'),
        ]);
    }

    public function offer_type_status_change(Request $request){
        $userdata = OfferType::find($request->id);

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

    public function offer_type_delete(Request $request){
        $userdata = OfferType::find($request->id);
        $userdata->delete();

         return response()->json([
            'status' => 'success',
            'msg' => 'data deleted success',
        ]);
    }
}
