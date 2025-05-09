<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (auth()->user()->role !== $role) {
            abort(403, 'Bạn không có quyền truy cập.');
        }
        return $next($request);
    }
}

