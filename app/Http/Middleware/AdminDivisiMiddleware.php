<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDivisiMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->divisi_id == 1) {
            return $next($request);
        }

        return redirect('/')->with('error', 'You do not have access to this page.');
    }
}
