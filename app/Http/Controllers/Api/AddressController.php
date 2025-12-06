<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\UserAddress;

class AddressController extends Controller
{
    public function store(Request $request){
        $rules = [
            'type' => 'required',
            'address_1' => 'required',
            'address_2' => 'required',
            'address_3' => 'required',
            'address_4' => 'required',
        ];
        $validator = Validator::make($request->all() , $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError(array(),$errorString);
        }else{
            $user = auth()->user();

            $data['user_id'] = $user->id;
            $data['type'] = $request->type;
            $data['address_1'] = $request->address_1;
            $data['address_2'] = $request->address_2;
            $data['address_3'] = $request->address_3;
            $data['address_4'] = $request->address_4;
            $address = UserAddress::create($data);

            return sendResponse($address, 'Address added successfully.'); 

        }
    }

    public function update(Request $request){
        $rules = [
            'id' => 'required',
            'type' => 'required',
            'address_1' => 'required',
            'address_2' => 'required',
            'address_3' => 'required',
            'address_4' => 'required',
        ];
        $validator = Validator::make($request->all() , $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError(array(),$errorString);
        }else{
            $user = auth()->user();
            $address = UserAddress::where('id',$request->id)->first();
            if(!$address){
                 return sendError(array(), 'Address not exists'); 
            }

            $address->update([
                'type' => $request->type,
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'address_3' => $request->address_3,
                'address_4' => $request->address_4,
            ]);

            return sendResponse($address, 'Address updated successfully.'); 

        }

        
    }
}