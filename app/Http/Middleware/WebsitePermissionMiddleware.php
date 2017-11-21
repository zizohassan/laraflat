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
    protected $router;
    protected $permissionsModel;

    public function __construct(Router $router , PermissionsModel $permissionsModel)
    {
        $this->router = $router;
        $this->permissionsModel  = $permissionsModel;
    }
    public function handle($request, Closure $next)
    {
            $user = Auth::user();
            $id = $this->router->getRoutes()->match($request)->hasParameter('id');
            $method = $this->router->getRoutes()->match($request)->getActionMethod();
            $model = strtolower(class_basename($this->router->getRoutes()->match($request)->getController()->model));
            $action = $this->getMethod($method , $id);
           if($action === false){
                return redirect(env('DENY_URL_PERMISSION'));
            }
           if($this->permissionsModel->canUser($user  ,$action, $model)){
                return $next($request);
            }
            return redirect(env('DENY_URL_PERMISSION'));
    }

    protected function actionsWithMethods(){
        return require_once app_path('Http/Middleware/CustomPermissions/website.php');
    }
}
