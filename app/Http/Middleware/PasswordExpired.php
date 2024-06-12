<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class PasswordExpired
{

    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $password_changed_at = new Carbon(($user->password_changed_at) ? $user->password_changed_at : $user->created_at);


        if (!is_null(env('PASSWORD_EXPIRY_DAYS'))) {
            if (Carbon::now()->diffInDays($password_changed_at) >= env('PASSWORD_EXPIRY_DAYS')) {
                return redirect()->route('password.expired');
            }
        }

        return $next($request);
    }
}