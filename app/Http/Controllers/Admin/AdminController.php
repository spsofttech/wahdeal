<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

   public function send_otp(Request $request)
    {
        $contactno = $request->contact_no;
        $contactdata = Admin::where('contact_no',$contactno)->first();

        if(!$contactdata){
            return back()->withErrors([
                'email' => 'Invalid Contactno.',
            ]);
        }


        $mobileNumber = $contactno;
        $otp = rand(1000, 9999);
        $responseData = send_otp($mobileNumber,$otp);
        
        if($responseData['type'] == 'error'){
            return back()->withErrors([
                'email' => $responseData['message'],
            ]);
        }else{
            $contactdata->otp = $otp;
            $contactdata->save();
            return redirect()->route('admin.showotp');
        }  
    }

    public function showotp()
    {
        return view('admin.showotp');
    }


    public function verify_otp(Request $request)
    {
        $otp = $request->otp;
        $branchdata = Admin::where('otp',$otp)->first();

        if(!$branchdata){
            return back()->withErrors([
                'email' => 'Invalid Otp.',
            ]);
        }
        
        Auth::guard('admin')->login($branchdata);
        $branchdata->otp = '';
        $branchdata->save();
        return redirect()->route('admin.dashboard');
    }

    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile',compact('admin'));
    }

     public function update_profile(Request $request){

        $user = Admin::find($request->id);
        $user->email = $request->email;
        $user->contact_no = $request->contact_no;
        $user->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Success',
            'redirect' => route('admin.profile'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}