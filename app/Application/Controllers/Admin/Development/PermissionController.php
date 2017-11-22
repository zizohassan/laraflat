<?php

namespace App\Application\Controllers\Admin\Development;

use App\Application\Controllers\AbstractController;
use App\Application\DataTables\PermissionsDataTable;
use App\Application\Model\Permission;
use App\Application\Requests\Admin\Permission\AddRequestPermission;
use App\Application\Requests\Admin\Permission\UpdateRequestPermission;
use Yajra\Datatables\Request;
use Alert;

class PermissionController extends AbstractController
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function index(PermissionsDataTable $dataTable){
        return $dataTable->render('admin.permission.index');
    }

    public function show($id = null){
        getControllerByType();
        $controller_type = getControllerType();
        return $this->createOrEdit('admin.permission.edit' , $id , ['controller_type' =>  $controller_type]);
    }

    public function store(AddRequestPermission $request){
        $nameSpace = ltrim(str_replace('-' , '\\' , $request->controller_name) , '\\');
        $request->request->add(['namespace' => $nameSpace]);
        $request->request->add(['controller_name' => class_basename($nameSpace)]);
         return $this->storeOrUpdate($request , null , 'admin/permission');
    }

    public function update($id , UpdateRequestPermission $request){
        $nameSpace = ltrim(str_replace('-' , '\\' , $request->controller_name) , '\\');
        $request->request->add(['namespace' => $nameSpace]);
        $request->request->add(['controller_name' => class_basename($nameSpace)]);
        return $this->storeOrUpdate($request , $id , 'admin/permission');
    }

    public function getById($id){
        $fields = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());
        $model = getModels();
        return $this->createOrEdit('admin.permission.show' , $id , ['fields' =>  $fields ,'model' => $model]);
    }

    public function destroy($id){
        return $this->deleteItem($id , 'admin/permission')->with('sucess' , 'Done Delete permission From system');
    }

    public function getControllerByType($type){
        return getControllerByType($type , 'json');
    }

    public function getMethodByController($controller  , $type){
        return getMethodByController($controller , $type);
    }

}
