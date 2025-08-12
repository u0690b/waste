<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UseCustomAuthHeader
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasHeader('X-Auth-Token')) {
            $request->headers->set('Authorization', $request->header('X-Auth-Token'));
        }
        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}
