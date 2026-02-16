<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->get('admin_auth', false)) {
            return redirect()->route('admin.login')->with('error', 'Please sign in to continue.');
        }

        return $next($request);
    }
}
