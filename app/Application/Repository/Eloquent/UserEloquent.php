<?php
namespace App\Application\Repository\Eloquent;

use App\Application\Model\Group;
use App\Application\Model\Permission;
use App\Application\Model\Role;
use App\Application\Model\User;
use App\Application\Repository\InterFaces\UserInterface;
use Illuminate\Support\Facades\Input;


class UserEloquent extends AbstractEloquent implements UserInterface{

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function checkRequest($request){
        if($request->password){
            $request->request->set('password' , bcrypt($request->password));
        }else{
            $request->request->remove('password');
        }
        return $request;
    }



    public function getPermissions()
    {
        $data['groups'] = Group::pluck('name' , 'id');
        $data['roles'] = Role::pluck('name' , 'id');
        $data['permissions'] = Permission::pluck('name' , 'id');
        return $data;
    }


    public function getPermissionById($id){
        return $this->model->where('id' , $id)->with('permission' ,'role')->first();
    }
}