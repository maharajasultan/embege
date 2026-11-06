<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Anda tidak memiliki akses ke panel admin.');
        }

        return $next($request);
    }
}
