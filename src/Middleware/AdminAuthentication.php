<?php

namespace App\Http\Middleware;

use App\Libraries\General;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

class AdminAuthentication
{
    public function handle(Request $request, Closure $next): Response
    {
        $user_id  = Session::get('iUserId');
        $username = Session::get('username');

        if ($request->path() == "admin/login") {
            if (!empty($user_id) && !empty($username)) {
                $permission = $this->getPermission();
                if ($permission === false) {
                    return Redirect::back()->withError('can not access without permission.');
                }
                View::share('permission', $permission);
                return redirect()->route('admin.dashboard');
            }
            return $next($request);
        }

        if (!empty($user_id) && !empty($username)) {
            $permission = $this->getPermission();
            if ($permission === false) {
                return Redirect::back()->withError('can not access without permission.');
            }
            View::share('permission', $permission);
            return $next($request);
        }

        return redirect()->route('admin.login');
    }

    private function getPermission()
    {
        $route  = request()->route();
        $action = $route->getAction();
        
        if (!isset($action['controller'])) {
            return false;
        }

        $controllerAction = explode('@', $action['controller']);
        
        if (count($controllerAction) < 2) {
            return false; 
        }

        $method = $controllerAction[1];
        $permission = General::check_module_permission();

        if (in_array($method, ['index', 'ajax_listing'])) {
            return $permission->eRead === 'Yes' ? $permission : false;
        }

        if (in_array($method, ['add', 'edit', 'store'])) {
            return $permission->eWrite === 'Yes' ? $permission : false;
        }

        return false;
    }
}
