<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductIssueCategory;
use App\Models\ProductIssueReason;

class HelpController extends Controller
{
    public function order_support_category()
    {
        $data = ProductIssueCategory::where('status', '1')
            ->with(['reasons' => function ($q) {
                $q->where('status', '1');
            }])
            ->orderBy('id', 'ASC')
            ->get();

         return sendResponse($data, 'Data fetch successfully.');
    }
}
