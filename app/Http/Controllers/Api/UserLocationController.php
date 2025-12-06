<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\UserLocation;

class UserLocationController extends Controller
{
    public function index(Request $request){
        $user = Auth::guard('api')->user();

        if($request->city && $request->state && $request->longitude && $request->latitude){
            
            $tot_count = UserLocation::where('user_id',$user->id)->count();
            if($tot_count >= 5){
                return sendError([], 'You can not add more than 5 address');
            }

            $location['status'] = '0';
            UserLocation::where('user_id',$user->id)->update($location);

            $location = new UserLocation;
            $location->user_id = $user->id;
            $location->city = $request->city;
            $location->state = $request->state;
            $location->latitude = $request->latitude;
            $location->longitude = $request->longitude;
            $location->address = $request->address;
            $location->flat_no = $request->flat;
            $location->floor = $request->floor;
            $location->land_mark = $request->landmark;
            $location->status = '1';
            $location->save();
        }

        $data = UserLocation::where('user_id',$user->id)->get();
        return sendResponse($data, 'Data fetch successfully.');

    }

    public function user_location_set(Request $request){

        $rules = [
            'id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();
        $exists = UserLocation::where('user_id',$user->id)->where('id',$request->id)->first();

        if(!$exists){
            return sendError([], 'Location not exists.');
        }

        $location['status'] = '0';
        UserLocation::where('user_id',$user->id)->update($location);

        $location1['status'] = '1';
        UserLocation::where('id',$request->id)->update($location1);

         $data = UserLocation::where('user_id',$user->id)->get();
        return sendResponse($data, 'Data fetch successfully.');

    }

    public function user_location_delete(Request $request){

        $rules = [
            'id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError([], $errorString);
        }

        $user = Auth::guard('api')->user();
        $exists = UserLocation::where('user_id',$user->id)->where('id',$request->id)->first();

        if(!$exists){
            return sendError([], 'Location not exists.');
        }

        if($exists->status == '1'){
            return sendError([], 'You can not delete the default location.');
        }


        UserLocation::where('id',$request->id)->delete();

        $data = UserLocation::where('user_id',$user->id)->get();
        return sendResponse($data, 'Data fetch successfully.');

    }
}
