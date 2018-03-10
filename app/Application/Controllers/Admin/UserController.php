<?php

namespace App\Application\Controllers\Admin;

use App\Application\Controllers\AbstractController;
use App\Application\DataTables\UserDataTable;
use App\Application\Model\User;
use App\Application\Repository\InterFaces\UserInterface;
use App\Application\Requests\Admin\User\AddRequestUser;
use App\Application\Requests\Admin\User\UpdateRequestUser;
use Yajra\Datatables\Request;

class UserController extends AbstractController
{
    protected $userInterface;
    protected $middleware;

    public function __construct(User $model , UserInterface $userInterface )
    {
        parent::__construct($model);
        $this->userInterface = $userInterface;
    }

    public function index(UserDataTable $dataTable )
    {
        return $dataTable->render('admin.user.index');
    }

    public function show($id = null){
        $data = $this->userInterface->getPermissions();
        $data['roles_permission'] = $this->userInterface->getPermissionById($id);
        return $this->createOrEdit('admin.user.edit' , $id , $data);
    }

    public function store(AddRequestUser $request){
        $request = $this->userInterface->checkRequest($request);
         return $this->storeOrUpdate($request , null , 'admin/user');
    }

    public function update($id , UpdateRequestUser $request){
        $request = $this->userInterface->checkRequest($request);
        return $this->storeOrUpdate($request , $id , 'admin/user');
    }

    public function getById($id){
        $fields = $this->model->findOrFail($id);
        return $this->createOrEdit('admin.user.show' , $id , ['fields' =>  $fields]);
    }

    public function destroy($id){
        return $this->deleteItem($id , 'admin/user');
    }

    public function pluck(\Illuminate\Http\Request $request){
        return $this->deleteItem($request->id , 'admin/user')->with('sucess' , 'Done Delete user From system');
    }

}
