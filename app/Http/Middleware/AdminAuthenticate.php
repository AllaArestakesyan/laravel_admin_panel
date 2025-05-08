<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{

    
    /**
     * Summary of handle
     * 
     * @param mixed $request
     * @param \Closure $next
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin.login.form');
        }

        return $next($request);
    }
}
