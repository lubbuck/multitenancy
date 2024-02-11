<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AccessControllMiddleware
{
    use AuthorizesRequests;

    public function handle(Request $request, Closure $next)
    {
        $this->authorize($request->route()->getName());

        return $next($request);
    }
}
