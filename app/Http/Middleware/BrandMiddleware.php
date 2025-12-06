<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BrandMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('brand')->check()) {
            if ($request->is('brand/login') || $request->is('brand/send_otp') || $request->is('brand/showotp') || $request->is('brand/verify_otp')) {
                return $next($request);
            }
            return redirect('/brand/login');
        }
        return $next($request);
    }
}
