<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $ip_address = $request->ip();
        $http_method = $request->method();
        $request_url = $request->fullUrl();
        $request_params = $request->all();

        Log::info("Request from IP: {$ip_address}, Method: {$http_method}, URL: {$request_url}, Params: " . json_encode($request_params));

        return $next($request);
    }
}
