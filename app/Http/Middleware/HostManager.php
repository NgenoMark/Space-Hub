<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class HostManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){
            return redirect()->route('login');

        }
        $userRole=Auth::user()->role;

        if($userRole=='hostmanager'){
            return $next($request);
        }

        if($userRole=='superadmin'){
            return redirect()->route('superadmin');
        }

        if($userRole=='admin'){
            return redirect()->route('admin');
        }

        if($userRole=='client'){
            return redirect()->route('dashboard');
        }

    }
}
