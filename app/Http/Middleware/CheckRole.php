<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('admin')->user();

        if ($user) {
            return $next($request);
        }

        return route('login.form');
    }
}
