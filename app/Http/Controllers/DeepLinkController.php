<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortLink;

class DeepLinkController extends Controller
{
    public function redirect($code, $id, $type, Request $request)
    {
        $userAgent = strtolower($request->userAgent());
        $link = ShortLink::where('code', $code)->first();

        if (!$link) {
            return redirect('/');
        }

        // App deep link scheme
        $appUrl = "wahdealapp://open?type={$link->type}&id={$link->item_id}";

        // Web fallback link
        $webUrl = match($link->type) {
            'event' => url("/about_brand/{$link->item_id}"),
            'product' => url("/about_brand/{$link->item_id}"),
            'brand' => url("/about_brand/{$link->item_id}"),
            'shoping_product' => url("/about_brand/{$link->item_id}"),
            default => url('/')
        };

        // Detect Android / iPhone and redirect directly
        if (strpos($userAgent, 'android') !== false || strpos($userAgent, 'iphone') !== false) {
            return redirect()->away($appUrl);
        }

        // Desktop or unknown → show HTML page that tries to open app, then fallback
        return view('deeplink_redirect', compact('appUrl', 'webUrl'));
    }
}
