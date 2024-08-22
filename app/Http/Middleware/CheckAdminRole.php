<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!in_array($request->user()->role, ['social services', 'admin'])) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
