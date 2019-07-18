<?php

namespace App\Http\Middleware;

use Symfony\Component\Yaml\Yaml;
use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', '*')
            ->header('Access-Control-Allow-Headers', '*')
            ->header('Access-Control-Allow-Credentials', 'true');
    }
}


