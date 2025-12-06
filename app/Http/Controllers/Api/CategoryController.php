<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {

        if($request->is_fashion == '1'){
              $categoriesQuery = Category::with(['subcategories'])
            ->where('is_fashion', '1')
            ->whereHas('brands', function($q) use ($request) {
                $q->where('status', '1');
            });
        }else{
            $categoriesQuery = Category::with(['subcategories'])
            ->whereHas('brands', function($q) use ($request) {
                $q->where('status', '1');
            });
        }


      

        $categories = $categoriesQuery->orderBy('rank', 'asc')->get();

        $categoryData = $categories->map(function($cat) {
            $subcategories = $cat->subcategories->map(function($sub) {
                return [
                    'subcategory_id' => $sub->id,
                    'subcategory_name' => $sub->name,
                    'brands_count' => $sub->brands()->where('status', '1')->count(),
                ];
            });

            return [
                'category_id' => $cat->id,
                'category_name' => $cat->name,
                'category_image' => asset('uploads/category/' . $cat->icon),
                'brands_count' => $cat->brands()->where('status', '1')->count(),
                'subcategories' => $subcategories
            ];
        });


        return sendResponse($categoryData, 'Category List Fetch Successfully.');
    }
}