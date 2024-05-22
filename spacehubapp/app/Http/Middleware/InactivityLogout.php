<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class InactivityLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $timeout = 10; // Set timeout in seconds
    
            $lastActivity = Session::get('lastActivityTime');
            $currentTime = time();
    
            // Debugging output
            logger('Last activity: ' . ($lastActivity ? date('Y-m-d H:i:s', $lastActivity) : 'None'));
            logger('Current time: ' . date('Y-m-d H:i:s', $currentTime));
    
            if ($lastActivity && ($currentTime - $lastActivity) > $timeout) {
                logger('User logged out due to inactivity');
                Auth::logout();
                Session::flush();
                return redirect('/login')->with('message', 'You have been logged out due to inactivity.');
            }
    
            Session::put('lastActivityTime', $currentTime);
        }
    
        return $next($request);
    }
    
}
