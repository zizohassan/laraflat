<?php

namespace App\Http\Middleware;

use App\Application\PermissionTraits\PermissionsModel;
use Closure;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
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
    protected function getAction($method , $array , $id){
        if(is_array($array)){
            if(count($array) > 1){
                if(($method == 'show' || $method == 'store') && $id === true){
                    return 'edit';
                }else if(($method == 'show' || $method == 'store')  && $id !== true){
                    return 'add';
                }
            }else{
                return $array[0];
            }
        }
        return false;
    }
    protected function getMethod($method , $id){
        $array  = $this->actionsWithMethods();
        if(array_key_exists($method , $array)){
            return $this->getAction($method , $array[$method] , $id);
        }
        return false;
    }
    protected function actionsWithMethods(){
        return [
            'show' =>  [
                'edit',
                'add'
            ],
            'store' => [
                'add'
            ],
            'update' => [
                'edit'
            ],
            'index' => [
                'view'
            ],
            'getById' => [
                'view'
            ],
            'destroy' => [
                'delete'
            ],
            'menuItem' =>[
                'add'
            ],
            'addNewItemToMenu' =>[
                'add'
            ],
            'deleteMenuItem' => [
                'delete'
            ],
            'getItemInfo' => [
                'edit'
            ],
            'updateOneMenuItem' => [
                'edit'
            ],
            'apiDocs' =>[
                'add'
             ],
            'icons' =>[
                'add'
            ],
            'replayEmail' =>[
                'edit'
            ],
        ];
    }
}
