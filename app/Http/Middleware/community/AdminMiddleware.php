<?php

namespace App\Http\Middleware\community;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role===ADMIN_ROLE){
            return $next($request);
        }

        Auth::logout();
        return redirect()->route('admin.login')->with('error', 'Please Login First');
    }
}
