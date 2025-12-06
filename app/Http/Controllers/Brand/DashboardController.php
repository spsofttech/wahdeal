<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('brand')->user();
        $total_branch =  Branch::where('brand_id',$admin->id)->count();
        return view('brand.dashboard',compact('total_branch'));
    }
}
