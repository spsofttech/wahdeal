<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('brand.login');
    }

    public function send_otp(Request $request)
    {
        $contactno = $request->contact_no;
        $contactdata = Branch::where('contact_no',$contactno)->where('status','1')->first();

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
            return redirect()->route('brand.showotp');
        }  
    }

    public function showotp()
    {
        return view('brand.showotp');
    }


    public function verify_otp(Request $request)
    {
        $otp = $request->otp;
        $branchdata = Branch::where('otp',$otp)->first();

        if(!$branchdata){
            return back()->withErrors([
                'email' => 'Invalid Otp.',
            ]);
        }
        
        Auth::guard('brand')->login($branchdata);
        $branchdata->otp = '';
        $branchdata->save();
        return redirect()->route('brand.dashboard');
    }

   

    public function logout(Request $request)
    {
        Auth::guard('brand')->logout();
        return redirect('/brand/login');
    }
}
