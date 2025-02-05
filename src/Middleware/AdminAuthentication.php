<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user_id     = Session::get('iUserId');
        $username    = Session::get('username');

        if($request->path() == "admin/login"){
            if(!empty($user_id) && !empty($username)){
                return redirect()->route('admin.dashboard');
            }
            return $next($request);
        }

        if(!empty($user_id) && !empty($username)){
            return $next($request);
        }

        return redirect()->route('admin.login');
    }
}
