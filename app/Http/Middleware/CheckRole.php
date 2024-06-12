<?php

namespace App\Http\Middleware;


use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        //password expire
        if (\Illuminate\Support\Facades\Auth::check() && $request->user()->hasRole($role)) {
            $passwordChangedAt = new Carbon(($request->user()->password_changed_at) ?  $request->user()->password_changed_at :  $request->user()->created_at);
            // if (Carbon::now()->diffInDays($passwordChangedAt) >= config('auth.password_expires_days')) {
            //     return redirect()->route('password-expired.index');
            // }
            //role
            if (!\Illuminate\Support\Facades\Auth::check()) {
                return redirect()->route('login');
            }
            if (Auth::user()->roles()->first()->name  == 'Administrator') {
                return $next($request);
            }
            //            elseif (Auth::user()->roles()->first()->name  == 'Practice' ) {
            //                return $next($request);
            //            elseif (Auth::user()->roles()->first()->name  == 'Billing Manager') {
            //                return $next($request);
            //            }
            //            }elseif(Auth::user()->roles()->first()->name  == 'Practice User'){
            //                return $next($request);
            //            }
            else {
                return redirect('/admin/home');
                //return abort('401');
            }
            //            $userRole=\Illuminate\Support\Facades\Auth::user()->roles()->first()->name;
            //            $roles=['Practice','Billing Manager','Practice User','Administrator'];
            //            if (in_array($userRole,$roles)) {
            //                // Redirect...
            //                return $next($request);
            //            }
            //            return response()->view('errors.error');
        }
        return response()->view('errors.error');
    }
}
