<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserBookAppointment;
use App\Models\UserBookAppointmentImage;

class BookingController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('brand')->user();
        return view('brand.booking');
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
            $columns = ['user_book_appointments.id'];

            $query = UserBookAppointment::
            join('users', 'users.id', '=', 'user_book_appointments.user_id')
            ->join('brands', 'brands.id', '=', 'user_book_appointments.brand_id')
            ->where('user_book_appointments.branch_id',$admin->id)
            ->select('user_book_appointments.*','users.first_name','users.last_name','users.email','users.mobile','brands.name as brand_name');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('users.first_name', 'like', "%{$search}%")
                     ->orWhere('users.last_name', 'like', "%{$search}%")
                     ->orWhere('users.email', 'like', "%{$search}%")
                     ->orWhere('users.mobile', 'like', "%{$search}%")
                      ->orWhere('brands.name', 'like', "%{$search}%");
                });
            }
        
            $query = $query->orderBy($columns[$orderColumn], $orderDir);


            $filtertotalget =  $query->get();
            $users = $query->skip($start)->take($length)->get();


            $totalRecords = UserBookAppointment::
            join('users', 'users.id', '=', 'user_book_appointments.user_id')
            ->join('brands', 'brands.id', '=', 'user_book_appointments.brand_id')
            ->where('user_book_appointments.branch_id',$admin->id)->count();
            $filteredRecords = count($filtertotalget);

        
            $i =  $request->get('start');
            $data = array();
            foreach($users as $val){
                $i++;

            
                if($val->is_booking_appointment == '1'){
                    $booking = 'Booking';
                }else{
                    $booking = 'Appointment';
                }

                $action = '
                        <a class="btn btn-link mybtn" href="' . route('brand.booking_view', $val->id) .'" style="color:green!important;">
                           <i class="fa fa-eye" style="color:#007bff!important;" title="View"></i>
                        </a>';
                
                $sub_array = [];
                $sub_array['no'] = $i;
                $sub_array['name'] = $val->first_name.' '.$val->last_name ?? '';
                $sub_array['email'] = $val->email ?? '';
                $sub_array['mobile'] = $val->mobile ?? '';
                $sub_array['brand'] = $val->brand_name ?? '';
                $sub_array['booking'] = $booking;
                $sub_array['status'] = $val->book_status_text;
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

     public function booking_view($id){
        $booking = UserBookAppointment::
            join('users', 'users.id', '=', 'user_book_appointments.user_id')
            ->join('brands', 'brands.id', '=', 'user_book_appointments.brand_id')
            ->leftjoin('booking_cancel_reasons', 'booking_cancel_reasons.id', '=', 'user_book_appointments.booking_cancel_reason_id')
            ->where('user_book_appointments.id',$id)
            ->select('user_book_appointments.*','users.first_name','users.last_name','users.email','users.mobile','brands.name as brand_name','booking_cancel_reasons.title as cancel_reason')
            ->first();
        $image = UserBookAppointmentImage::
        leftjoin('category_fields', 'category_fields.id', '=', 'user_book_appointment_images.category_field_id')
        ->where('user_book_appointment_images.user_book_appointment_id',$id)
        ->select('category_fields.label','user_book_appointment_images.*')
        ->get();


        $bookdata = json_decode($booking->form_data, true);
       
        return view('brand.booking_view',compact('id','booking','image','bookdata'));
    }

    public function booking_change_status(Request $request){
        $id = $request->id;

        $booking = UserBookAppointment::where('id',$id)->first();
        $booking->book_status = $request->status;
        $booking->save();

        
        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully!'
        ]);
    }
}
