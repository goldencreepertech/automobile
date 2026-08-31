<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureApiOnly
{
    public function handle(Request $request, \Closure $next)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return $next($request);
        }

        return response()->json(['message' => 'API only.'], Response::HTTP_FORBIDDEN);
    }
}
