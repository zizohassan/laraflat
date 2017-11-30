<?php

namespace App\Http\Middleware;

use App\Http\Middleware\CustomPermissions\PermissionTrait;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminPermissionMiddleware
{
    use PermissionTrait;

    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $method = request()->route()->getActionMethod();
        $controller = explode('@', request()->route()->getActionName())[0];
        $this->can($user , 'admin');

        if (!key_exists($controller, $this->permission)) {
            return redirect(env('DENY_URL_PERMISSION'));
        }
        if (!isset($this->permission[$controller])) {
            return redirect(env('DENY_URL_PERMISSION'));
        }
        if (!isset($this->permission[$controller][$method])) {
            return redirect(env('DENY_URL_PERMISSION'));
        }
        if ($this->permission[$controller][$method] != 1) {
            return redirect(env('DENY_URL_PERMISSION'));
        }
        return $next($request);

    }

    protected function actionsWithMethods()
    {
        return require_once app_path('Http/Middleware/CustomPermissions/admin.php');
    }
}
