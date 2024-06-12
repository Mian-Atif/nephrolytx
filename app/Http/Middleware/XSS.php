<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class XSS
{
    public function handle(Request $request, Closure $next)
    {
        if (!in_array(strtolower($request->method()), ['put', 'post','patch'])) {
            return $next($request);
        }

        $input = $request->all();

        array_walk_recursive($input, function(&$input) {
            $input = strip_tags($input);
        });

        $request->merge($input);

        return $next($request);
    }
}