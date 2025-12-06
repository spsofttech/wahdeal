<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        $total_category =  Category::where('name','!=','All')->count();
        $total_subcategory =  SubCategory::count();
        $total_brand =  Brand::count();
        $total_product =  Product::count();
        $total_user =  User::count();
        $total_event =  Event::count();

        
        $data['total_category'] = $total_category;
        $data['total_subcategory'] = $total_subcategory;
        $data['total_brand'] = $total_brand;
        $data['total_product'] = $total_product;
        $data['total_user'] = $total_user;
        $data['total_event'] = $total_event;
        return view('admin.dashboard',compact('data'));
    }
}