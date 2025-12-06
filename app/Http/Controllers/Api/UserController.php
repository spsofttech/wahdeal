<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\OtpVerification;


class UserController extends Controller
{

    public function send_otp(Request $request){
        $rules = [
            'type' => 'required'
        ];
        $validator = Validator::make($request->all() , $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError(array(),$errorString);
        }

        if($request->type == '0'){
            $rules = [
            'email' => 'required|email',
            ];
            $validator = Validator::make($request->all() , $rules);
            if ($validator->fails()) {
                $errorString = implode(",", $validator->messages()->all());
                return sendError(array(),$errorString);
            }else{
                    $exists = User::select('*')->where('email',$request->email)->first();
                    $ref_user_id = '0';
                    if($request->promo_code){
                        $existspromo = User::select('id')->where('promo_code',$request->promo_code)->first();
                        if(!$existspromo){
                                return sendError(array(), 'Promo code not valid'); 
                        }
                        $ref_user_id = $existspromo->id;

                    }

                    if(!$exists){
                        $promocode = generatePromoCode();
                        $data = array(
                            "country_code"=>$request->country_code,
                            "promo_code"=>$promocode,
                            "ref_user_id"=>$ref_user_id,
                            "email" => $request->email,
                            "status" => '1',
                            "image" => 'user.png',
                        );

                        $user = User::create($data);

                    
                    }else{
                        if($exists->status != '1'){
                            return sendError(array(), 'Your account has been deactive please contact to admin'); 
                        }

                        if($request->is_allow != '1'){
                            if($exists->last_login_token != ''){
                                     return response()->json([
                                        'status' => 0,
                                        'already_login_status' => 2,
                                        'data' => (object)[],
                                        'message' => 'Your account has already login in second device'
                                    ], 200);
                            }
                        }
                        
                    }

                    $toEmail = $request->email;
                    $subject = 'Your Otp.';
                    $otp = rand(1000, 9999);

                    $messageContent = View::make('email.otp',compact('otp'))->render(); 
                    
                    Mail::send([], [], function ($message) use ($toEmail, $subject, $messageContent) {
                    $message->to($toEmail)
                            ->subject($subject)
                            ->html($messageContent, 'text/html');
                    });

                    OtpVerification::where('email',$request->email)->delete();

                    $otpdata = new OtpVerification;
                    $otpdata->email = $request->email;
                    $otpdata->otp = $otp;
                    $otpdata->save();

                    $data = array();
                    return sendResponse($data, 'Otp sent in mail successfully.'); 

            }
        }else{
            $rules = [
            'mobile' => 'required'
            ];
            $validator = Validator::make($request->all() , $rules);
            if ($validator->fails()) {
                $errorString = implode(",", $validator->messages()->all());
                return sendError(array(),$errorString);
            }else{

                $exists = User::select('id','status','last_login_token')->where('mobile',$request->mobile)->first();

                $ref_user_id = '0';
                if($request->promo_code){
                    $existspromo = User::select('id')->where('promo_code',$request->promo_code)->first();
                    if(!$existspromo){
                            return sendError(array(), 'Promo code not valid'); 
                    }
                    $ref_user_id = $existspromo->id;
                }


                if(!$exists){
                    $promocode = generatePromoCode();
                    $data = array(
                        "country_code"=>$request->country_code,
                        "promo_code"=>$promocode,
                        "ref_user_id"=>$ref_user_id,
                        "mobile" => $request->mobile,
                        "status" => '1',
                        "image" => 'user.png',
                    );

                    $user = User::create($data);

                }else{
                    if($exists->status != '1'){
                        return sendError(array(), 'Your account has been deactive please contact to admin'); 
                    }

                    if($request->is_allow != '1'){
                            if($exists->last_login_token != ''){
                                     return response()->json([
                                        'status' => 0,
                                        'already_login_status' => 2,
                                        'data' => (object)[],
                                        'message' => 'Your account has already login in second device'
                                    ], 200);
                            }
                    }

                }

                $mobileNumber = $request->mobile;
                $otp = rand(1000, 9999);
                
                $responseData = send_otp($mobileNumber,$otp);
                
                if($responseData['type'] == 'error'){
                    return sendError(array(), $responseData['message']); 
                }else{
                    OtpVerification::where('mobile',$request->mobile)->delete();

                    $otpdata = new OtpVerification;
                    $otpdata->mobile = $request->mobile;
                    $otpdata->otp = $otp;
                    $otpdata->save();

                    return sendResponse(array(), 'Otp sent in mobile successfully.');
                }  
            }
        }
    }

    public function verify_otp(Request $request) {
        $rules = [
            'type' => 'required',
            'fcm_token' => 'required'
        ];
        $validator = Validator::make($request->all() , $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError(array(),$errorString);
        }

        $otp = $request->otp;

        if($request->type == '0'){
            $rules = [
            'email' => 'required|email',
            ];
            $validator = Validator::make($request->all() , $rules);
            if ($validator->fails()) {
                $errorString = implode(",", $validator->messages()->all());
                return sendError(array(),$errorString);
            }else{
                $verify = OtpVerification::select('id')->where('email',$request->email)->where('otp',$otp)->first();
                if($verify){

                    $user = User::where('email', $request->email)->first();
                    if (!$user) {
                        return sendError(array(), "User not found");
                    }

                    OtpVerification::where('email',$request->email)->delete();

                    $credentials = $request->only('email');

                   

                    $checkexists = User::where('email', $request->email)->first();
                    if ($checkexists && $checkexists->last_login_token) {
                        JWTAuth::setToken($checkexists->last_login_token)->invalidate();
                    }

                    $token = JWTAuth::fromUser($user);

                    $update['last_login_token']= $token;
                    $update['fcm_token']= $request->fcm_token;
                    $update['email_verified_at']= now();
                    User::where('email', $request->email)->update($update);
                    $userdata = get_user_profile($user->id);

                    return sendResponse($userdata, 'Login successfully.'); 
                }else{
                        return sendError(array(), 'Invalid otp.'); 
                }
            }
        }else{
            $rules = [
            'mobile' => 'required',
            ];
            $validator = Validator::make($request->all() , $rules);
            if ($validator->fails()) {
                $errorString = implode(",", $validator->messages()->all());
                return sendError(array(),$errorString);
            }else{
                $mobileNumber = $request->mobile;

                $user = User::where('mobile', $request->mobile)->first();
                if (!$user) {
                    return sendError(array(), "User not found");
                }

                    $curl = curl_init();
                    curl_setopt_array($curl, [
                    CURLOPT_URL => "https://control.msg91.com/api/v5/otp/verify?otp=".$otp."&mobile=91".$mobileNumber,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "accept: application/json",
                        "authkey: 402941AZXuEbdz64d1c980P1"
                    ],
                ]);
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);

                    $responseData = json_decode($response, true);
                    if($responseData['type'] == 'error'){
                        return sendError(array(), $responseData['message']); 
                    }else{
                        OtpVerification::where('mobile',$mobileNumber)->delete();
                        
                        $credentials = $request->only('mobile');

                        $checkexists = User::where('mobile', $request->mobile)->first();
                        if ($checkexists && $checkexists->last_login_token) {
                            JWTAuth::setToken($checkexists->last_login_token)->invalidate();
                        }

                        $token = JWTAuth::fromUser($user);

                        $update['last_login_token']= $token;
                        $update['fcm_token']= $request->fcm_token;
                        $update['email_verified_at']= now();
                        User::where('mobile', $request->mobile)->update($update);
                        $userdata = get_user_profile($user->id);

                        return sendResponse($userdata, 'Login successfully.');
                    }  

            }
        }
        
    }

    public function login(Request $request) {
        $rules = [
            'email' => 'required',
            'password' => 'required',
            'fcm_token' => 'required'
        ];
        $validator = Validator::make($request->all() , $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError(array(),$errorString);
        }

        $user = User::select('*')->where('email',$request->email)->first();
        if (!$user) {
            return sendError(array(), 'Email not exists'); 
        }

        if($user->status != '1'){
            return sendError(array(), 'Your account has been deactive please contact to admin'); 
        }

        if($request->is_allow != '1'){
            if($user->last_login_token != ''){
                        return response()->json([
                        'status' => 0,
                        'already_login_status' => 2,
                        'data' => (object)[],
                        'message' => 'Your account has already login in second device'
                    ], 200);
            }
        }

        $credentials = $request->only('email', 'password');

        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return sendError(array(), 'Invalid email or password');
        }

        $checkexists = User::where('email', $request->email)->first();

        if ($checkexists && $checkexists->last_login_token) {
            JWTAuth::setToken($checkexists->last_login_token)->invalidate();
        }

        $token = JWTAuth::fromUser($user);

        $update['last_login_token']= $token;
        $update['fcm_token']= $request->fcm_token;
        User::where('email', $request->email)->update($update);
        $userdata = get_user_profile($user->id);

        return sendResponse($userdata, 'Login successfully.');

    }


    public function update_profile(Request $request) {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
        ];
        $validator = Validator::make($request->all() , $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError(array(),$errorString);
        }else{
            $user = auth()->user();


            if($request->email){
                $checkexists = User::where('email', $request->email)->where('id','!=',$user->id)->first();
                if($checkexists){
                    return sendError(array(), 'Sorry email already exists.');
                }
            }

            if($request->mobile){
                $checkexists = User::where('mobile', $request->mobile)->where('id','!=',$user->id)->first();
                if($checkexists){
                    return sendError(array(), 'Sorry mobile already exists.');
                }
            }

            $udata = User::where('id', $user->id)->first();

           

            $update['first_name']= $request->first_name;
            $update['last_name']= $request->last_name;
            $update['gender']= $request->gender;
         

            if($request->email){
                $update['email']= $request->email;
            }

            if($request->mobile){
                $update['mobile']= $request->mobile;
            }

          
            if($request->file('profile_image')){
                $profile_image = $request->file('profile_image');
                if ($user->image && File::exists(public_path('uploads/user/' . $user->image))) {
                    File::delete(public_path('uploads/user/' . $user->image));
                }

                $profileimgname = 'USER_'.$user->id.'_'.time().'.'.$profile_image->getClientOriginalExtension();
                $request->profile_image->move(public_path('uploads/user/'), $profileimgname);
                $update['image'] = $profileimgname;
            }

            
            User::where('id', $user->id)->update($update);
            $userdata =  get_user_profile($user->id);
            return sendResponse($userdata, 'Profile updated successfully!');
        }
    }

    public function update_password(Request $request) {
        $rules = [
            'password' => 'required',
        ];
        $validator = Validator::make($request->all() , $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError(array(),$errorString);
        }else{
            $user = auth()->user();

            $password = bcrypt($request->password);
            $update['password']= $password;
            User::where('id', $user->id)->update($update);
            
            $userdata =  get_user_profile($user->id);
            return sendResponse($userdata, 'Password change successfully!');
        }
    }


    public function user_profile(Request $request)
    {
       $user = auth()->user();

        $token = $request->bearerToken();
        $exists = User::where('last_login_token', $token)->first();
        if(!$exists){
             return response()->json(['success' => true, 'data' => ['result' => [], 'message' => 'Unauthorized.']], 401);
        }

       $user_info = get_user_profile($user->id);
       return sendResponse($user_info, 'Success');
    }


    public function promo_code_submit(Request $request) {
        $rules = [
            'promo_code' => 'required',
        ];
        $validator = Validator::make($request->all() , $rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return sendError(array(),$errorString);
        }

        $user = auth()->user();

        $promocode = User::select('id','promo_code')->where('promo_code',$request->promo_code)->first();
        if (!$promocode) {
            return sendError(array(), 'Promo code not exists'); 
        }

        $ref_user_id = $promocode->id;
        $update['ref_user_id'] = $ref_user_id;
        User::where('id', $user->id)->update($update);


        $userdata = get_user_profile($user->id);

        return sendResponse($userdata, 'Code submit successfully.');

    }

    public function invited_friend(Request $request)
    {
        $user = Auth::guard('api')->user();
        
        $u_data = User::where('ref_user_id', $user->id)
            ->select('id','first_name','last_name','image','created_at')
            ->orderByDesc('id')->get();
       
        
        return sendResponse($u_data, 'Data Fetch Successfully.'); 

        
    }

    public function logout()
    {
        Auth::logout();
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

   


}