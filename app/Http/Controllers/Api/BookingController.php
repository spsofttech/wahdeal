<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Brand;
use App\Models\Branch;
use App\Models\Category;
use App\Models\UserBookAppointment;
use App\Models\UserBookAppointmentImage;
use App\Models\BookingCancelReason;

class BookingController extends Controller
{
    public function create_booking(Request $request)
    {
        $rules = [
            'brand_id' => 'required',
            'branch_id' => 'required',
            'form' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();
        if (!$user) {
            return sendError(array(), 'User not exists'); 
        }

        $brand = Brand::where('id',$request->brand_id)->first();
        if(!$brand){
            return sendError(array(), 'Brand not exists'); 
        }

        $branch = Branch::where('id',$request->branch_id)->first();
        if(!$branch){
            return sendError(array(), 'Branch not exists'); 
        }

        $cat = Category::where('id',$brand->category_id)->first();
        if($cat->is_booking == '1'){
            $is_booking_appointment = '1';
        }else{
            $is_booking_appointment = '2';
        }

        $book = new UserBookAppointment;
        $book->user_id = $user->id;
        $book->brand_id = $request->brand_id;
        $book->branch_id = $request->branch_id;
        $book->is_booking_appointment = $is_booking_appointment;
        $book->form_data = $request->form;
        $book->book_status = '0';
        $book->save();
        

        if($request->image){
            $images = explode(',',$request->image);
            foreach ($images as $fieldId) {
                    if ($request->hasFile($fieldId)) {
                        $file = $request->file($fieldId);
                        $filename = 'booking_'.time() . '_' . $fieldId . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/booking'), $filename);

                        $bookimage = new UserBookAppointmentImage;
                        $bookimage->user_book_appointment_id = $book->id;
                        $bookimage->category_field_id = $fieldId;
                        $bookimage->image = $filename;
                        $bookimage->save();
                    }
            }
        }

        return sendResponse($book, 'Booking successfully.');
    }

    public function booking_history(Request $request)
    {
        $rules = [
            'page' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();
        if (!$user) {
            return sendError([], 'User not exists');
        }

        $page = $request->page;
        $limit = env('PAGINATION_LIMIT', 10);
        $offset = ($page - 1) * $limit;   // ← FIXED

        // MAIN QUERY
        $booking = UserBookAppointment::where('user_id', $user->id);

        // FILTER : Status
        if ($request->book_status != '') {
            $booking->where('book_status', $request->book_status);
        }

        $total_count = (clone $booking)->count();

        
        $paginationdata = $booking
            ->orderBy('id', 'DESC')
            ->skip($offset)
            ->take($limit)
            ->get();

        $Booking_Data = [];
        foreach ($paginationdata as $val) {

            $brand = Brand::where('id',$val['brand_id'])->select('id','name','icon')->first();
            $branch = Branch::where('id',$val['branch_id'])->select('id','state','city','area','pincode','address')->first();
        
            $formdata = json_decode($val['form_data'], true);
            $dateValue = collect($formdata)->firstWhere('type', 'date')['value'] ?? '';
            $dateRange = collect($formdata)->firstWhere('type', 'daterange')['value'] ?? '';
            $Time = collect($formdata)->firstWhere('type', 'time')['value'] ?? '';

            $cancelReason = (object)array();
            if ($val->booking_cancel_reason_id) {
                $cancelReason = BookingCancelReason::select('id','title')
                                ->find($val->booking_cancel_reason_id);
            }

            if($val['is_booking_appointment'] == '1'){
                $bookingtype = 'Booking';
            }else{
                $bookingtype = 'Appointment';
            }

            $images = UserBookAppointmentImage::where('user_book_appointment_id',$val['id'])->get();
      

            $Booking_Data[] = [
                'id'  => $val['id'],
                'type'  => $bookingtype,
                'brand'  => $brand,
                'location'  => $branch,
                'date' => $dateValue,
                'date_range' => $dateRange,
                'created_at' => $val['created_at'],
                'time' => $Time,
                'status' => $val['book_status'],
                'book_status_text' => $val['book_status_text'],
                'cancel_reason' => $cancelReason,
                'cancel_other_reason' => $val['booking_cancel_reason_other'],
                'detail' => $formdata,
                'images' => $images
            ];
        }

        // NEXT PAGE LOGIC
        $total_page = ceil($total_count / $limit);
        $is_nextpage = ($total_page > $page) ? '1' : '0';

        $booking_status_types = UserBookAppointment::statusList();

        $reasons = BookingCancelReason::where('status', '1')->get();

        $data['booking'] = $Booking_Data;
        $data['status_type'] = $booking_status_types;
        $data['cancel_reason'] = $reasons;

        return sendResponsePagination($data, 'Booking History Fetched Successfully.', $is_nextpage);
    }

  

    public function booking_cancel(Request $request){
        $rules = [
            'id' => 'required',
            'cancel_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = auth()->id();

        $user = Auth::guard('api')->user();
        if (!$user) {
            return sendError(array(), 'User not exists'); 
        }

        $bookdetail = UserBookAppointment::where('id', $request->id)->first();
        if (!$bookdetail) {
            return sendError(array(), 'Booking not exists'); 
        }

        $reason = BookingCancelReason::where('id', $request->cancel_id)->first();
        if (!$reason) {
            return sendError(array(), 'Reason not exists'); 
        }

        $bookdetail->book_status = '3';
        $bookdetail->booking_cancel_reason_id = $request->cancel_id;
        $bookdetail->booking_cancel_reason_other = $request->reason;
        $bookdetail->save();
        
        return sendResponse(array(), 'Booking cancelled successfully.');
    }
}
