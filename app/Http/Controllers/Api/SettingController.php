<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class SettingController extends Controller
{
    public function notification_setting(Request $request) {
        $user = auth()->user();

        $userdata = User::where('id', $user->id)->first();
        if($userdata->notification_setting == '1'){
            $update['notification_setting']= '0';
        }else{
            $update['notification_setting']= '1';
        }

        User::where('id', $user->id)->update($update);
        
        $userdata =  get_user_profile($user->id);
        return sendResponse($userdata, 'Notification setting change successfully!');
    }
}