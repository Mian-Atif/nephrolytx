<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class TwoFactor
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

        $user = auth()->user();


        if(!Session::get('twoFactor')) {
            return redirect()->route('verify.index');
        }

        if(auth()->check() && $user->two_factor_code)
        {
            if($user->two_factor_expires_at->lt(now()))
            {
                $user->resetTwoFactorCode();
                auth()->logout();

                return redirect()->route('login')
                    ->with(['success' => 'The two factor code has expired. Please login again.']);
            }

            if(!$request->is('verify*'))
            {
                return redirect()->route('verify.index');
            }
        }


        return $next($request);
    }
}
