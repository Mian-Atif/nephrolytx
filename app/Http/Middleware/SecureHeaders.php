<?php

namespace App\Http\Middleware;

use Closure;

class SecureHeaders
{
    private $unwantedHeaderList = [
        'X-Powered-By',
        'Server',
    ];
    public function handle($request, Closure $next)
    {
        $this->removeUnwantedHeaders($this->unwantedHeaderList);
        $response = $next($request);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
//        $response->headers->set('Content-Security-Policy', "style-src 'self'");
        $response->headers->set('Cache-Control', 'no-cache, must-revalidate, no-store, max-age=0, private');
        $response->headers->set('Referrer-Policy', 'no-referrer');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        $response->headers->set('X-Powered-By', 'unKnown');
        $response->headers->set('Server', 'unKnown');
        return $response;
    }
    private function removeUnwantedHeaders($headerList)
    {
        foreach ($headerList as $header)
            header_remove($header);
    }
}