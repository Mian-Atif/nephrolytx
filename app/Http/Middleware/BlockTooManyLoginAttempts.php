<?php

namespace App\Http\Middleware;

use App\Models\Access\User\LoginAttemptLog;
use Closure;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class BlockTooManyLoginAttempts
{
    /**
     * The rate limiter instance.
     *
     * @var \Illuminate\Cache\RateLimiter
     */
    protected $limiter;

    /**
     * Create a new request throttler.
     *
     * @param \Illuminate\Cache\RateLimiter $limiter
     */
    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param int $maxAttempts
     * @param int $decayMinutes
     * @return mixed
     */
    public function handle($request, Closure $next, $maxAttempts = 5, $decaySeconds = 720)
    {

        //Create Log for Login Attempt
        LoginAttemptLog::create([
            'email' => $request->get('email'),
            'description' => 'Too Many Attempt For Login. Account Lockout!'

        ]);

        $key = $this->resolveRequestSignature($request);

        if ($this->limiter->tooManyAttempts($key, $maxAttempts, $decaySeconds)) {
            return $this->buildResponse($key, $maxAttempts);
        }

        $this->limiter->hit($key, $decaySeconds);

        $response = $next($request);

        return $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts)
        );
    }

    /**
     * Resolve request signature.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function resolveRequestSignature($request)
    {
        return $request->fingerprint();
    }

    /**
     * Create a 'too many attempts' response.
     *
     * @param string $key
     * @param int $maxAttempts
     * @return \Illuminate\Http\Response
     */
    protected function buildResponse($key, $maxAttempts)
    {
        $retryAfter = ceil($this->limiter->availableIn($key) / 60);
        $message = response()->json([
            'message' => "Too many login attempts. Please try again after $retryAfter minutes.", //may comes from lang file
            'status' => false
        ], 429);


        return $this->addHeaders(
            $message, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
            $retryAfter
        );
    }

    /**
     * Add the limit header information to the given response.
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param int $maxAttempts
     * @param int $remainingAttempts
     * @param int|null $retryAfter
     * @return \Illuminate\Http\Response
     */
    protected function addHeaders(Response $response, $maxAttempts, $remainingAttempts, $retryAfter = null)
    {
        $headers = [
            'X-RateLimit-Limit' => $maxAttempts,
            'X-RateLimit-Remaining' => $remainingAttempts,
        ];

        if (!is_null($retryAfter)) {
            $headers['Retry-After'] = $retryAfter;
            $headers['Content-Type'] = 'application/json';
        }

        $response->headers->add($headers);

        return $response;
    }

    /**
     * Calculate the number of remaining attempts.
     *
     * @param string $key
     * @param int $maxAttempts
     * @param int|null $retryAfter
     * @return int
     */
    protected function calculateRemainingAttempts($key, $maxAttempts, $retryAfter = null)
    {
        if (!is_null($retryAfter)) {
            return 0;
        }

        return $this->limiter->retriesLeft($key, $maxAttempts);
    }
}