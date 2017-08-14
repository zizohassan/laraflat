<?php

namespace App\Application\Controllers\Admin;

use App\Application\Controllers\AbstractController;
use App\Application\DataTables\CategoriesDataTable;
use App\Application\Model\Categorie;
use App\Application\Requests\Admin\Categorie\AddRequestCategorie;
use App\Application\Requests\Admin\Categorie\UpdateRequestCategorie;
use Yajra\Datatables\Request;
use Alert;

class CategorieController extends AbstractController
{
    public function __construct(Categorie $model)
    {
        parent::__construct($model);
    }

    public function index(CategoriesDataTable $dataTable){
        return $dataTable->render('admin.categorie.index');
    }

    public function show($id = null){
        return $this->createOrEdit('admin.categorie.edit' , $id);
    }

    public function store(AddRequestCategorie $request){
         return $this->storeOrUpdate($request , null , 'admin/categorie');
    }


    public function update($id , UpdateRequestCategorie $request){
        return $this->storeOrUpdate($request , $id , 'admin/categorie');
    }

    public function getById($id){
        $fields = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());
        return $this->createOrEdit('admin.categorie.show' , $id , ['fields' =>  $fields]);
    }

    public function destroy($id){
        return $this->deleteItem($id , 'admin/categorie')->with('sucess' , 'Done Delete categorie From system');
    }
}
