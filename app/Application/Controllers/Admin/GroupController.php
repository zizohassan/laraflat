<?php

namespace App\Application\Controllers\Admin;

use App\Application\Controllers\AbstractController;
use App\Application\DataTables\GroupsDataTable;
use App\Application\Model\Group;
use App\Application\Repository\InterFaces\GroupInterface;
use App\Application\Repository\InterFaces\UserInterface;
use App\Application\Requests\Admin\Group\AddRequestGroup;
use App\Application\Requests\Admin\Group\UpdateRequestGroup;
use Yajra\Datatables\Request;
use Alert;

class GroupController extends AbstractController
{
    protected $userInterface;

    protected $groupInterface;

    public function __construct(Group $model , UserInterface $userInterface , GroupInterface $groupInterface)
    {
        parent::__construct($model);
        $this->userInterface = $userInterface;
        $this->groupInterface = $groupInterface;
    }

    public function index(GroupsDataTable $dataTable){
        return $dataTable->render('admin.group.index');
    }

    public function show($id = null){
        $data = $this->userInterface->getPermissions();
        $data['roles_permission'] = $this->groupInterface->getPermissionById($id);
        return $this->createOrEdit('admin.group.edit' , $id , $data);
    }

    public function store(AddRequestGroup $request){
         return $this->storeOrUpdate($request , null , 'admin/group');
    }

    public function update($id , UpdateRequestGroup  $request){
        return $this->storeOrUpdate($request , $id , 'admin/group');
    }

    public function getById($id){
        $fields = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());
        return $this->createOrEdit('admin.group.show' , $id , ['fields' =>  $fields]);
    }

    public function destroy($id){
        return $this->deleteItem($id , 'admin/group')->with('sucess' , 'Done Delete group From system');
    }

    public function pluck(\Illuminate\Http\Request $request){
        return $this->deleteItem($request->id , 'admin/group')->with('sucess' , 'Done Delete group From system');
    }
}
