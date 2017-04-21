<?php

namespace App\Application\Controllers\Admin;

use App\Application\Controllers\AbstractController;
use App\Application\DataTables\PermissionsDataTable;
use App\Application\Model\Permission;
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
        $model = getModels();
        return $this->createOrEdit('admin.permission.edit' , $id , ['model' => $model]);
    }

    public function store($id = null , \Illuminate\Http\Request $request){
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
}
