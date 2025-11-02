<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if( Auth::user() ){
            if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' ){
                return $request->route()->getName() == 'login' || $request->route()->getName() == 'register' ? to_route('admin#home'):$next($request);
            }else{
                return to_route('user#home');
            }
        }else{
            return $next($request);
        }
    }
}
