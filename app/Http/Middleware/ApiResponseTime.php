<?php

namespace App\Http\Middleware;

use Closure;

class ApiResponseTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $response = $next($request);

        if($response->headers->get('content-type') == 'application/json')
        {
            $collection = $response->original;
            $collection['timestamp'] = microtime(true) - LARAVEL_START;
            $response->setContent(json_encode($collection));
        }

        return $response;
    }
}
