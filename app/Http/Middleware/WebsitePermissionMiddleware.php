<?php

namespace App\Http\Middleware;

use App\Application\PermissionTraits\PermissionsModel;
use App\Http\Middleware\CustomPermissions\PermissionTrait;
use Closure;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;

class WebsitePermissionMiddleware
{
    use PermissionTrait;

    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $method = request()->route()->getActionMethod();
        $controller = explode('@', request()->route()->getActionName())[0];
        $this->can($user , 'website');
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
        return require_once app_path('Http/Middleware/CustomPermissions/website.php');
    }
}
