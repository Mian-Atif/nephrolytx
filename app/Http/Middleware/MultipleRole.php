<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MultipleRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('login');
        }
            if (Auth::user()->roles()->first()->name == 'Practice') {
                return $next($request);
            } elseif (Auth::user()->roles()->first()->name == 'Billing Manager') {
                return $next($request);
            } elseif (Auth::user()->roles()->first()->name == 'Practice User') {
                return $next($request);
            }

        else{
            return abort('401');
        }
        return $next($request);
    }
}
