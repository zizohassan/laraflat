<?php

namespace App\Application\Controllers\Admin;

use App\Application\Controllers\AbstractController;
use App\Application\DataTables\LogsDataTable;
use App\Application\Model\Log;
use Yajra\Datatables\Request;
use Alert;

class LogController extends AbstractController
{
    public function __construct(Log $model)
    {
        parent::__construct($model);
    }

    public function index(LogsDataTable $dataTable){
        return $dataTable->render('admin.log.index');
    }

    public function show($id = null){
        return $this->createOrEdit('admin.log.edit' , $id);
    }

    public function store($id = null , \Illuminate\Http\Request $request){
         return $this->storeOrUpdate($request , $id , 'admin/log');
    }

    public function getById($id){
        $fields = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());
        return $this->createOrEdit('admin.log.show' , $id , ['fields' =>  $fields]);
    }

    public function destroy($id){
        return $this->deleteItem($id , 'admin/log')->with('sucess' , 'Done Delete log From system');
    }

    public function pluck(\Illuminate\Http\Request $request){
        return $this->deleteItem($request->id , 'admin/log')->with('sucess' , 'Done Delete log From system');
    }
}
