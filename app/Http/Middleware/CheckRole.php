<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!in_array($request->user()->role, [ 'social services'])) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
