<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminMiddleware
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
       if (!Auth::guard('admin')->check()) {
            if ($request->is('admin/login') || $request->is('admin/send_otp') || $request->is('admin/showotp') || $request->is('admin/verify_otp')) {
                return $next($request);
            }
            return redirect('/admin/login');
        }
        return $next($request);
    }
}