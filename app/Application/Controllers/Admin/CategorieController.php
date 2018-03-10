<?php

namespace App\Application\Controllers\Admin;

use App\Application\Requests\Admin\Categorie\AddRequestCategorie;
use App\Application\Requests\Admin\Categorie\UpdateRequestCategorie;
use App\Application\Controllers\AbstractController;
use App\Application\DataTables\CategoriesDataTable;
use App\Application\Model\Categorie;
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
          $item =  $this->storeOrUpdate($request , null , true);
          return redirect('admin/categorie');
     }

     public function update($id , UpdateRequestCategorie $request){
          $item =  $this->storeOrUpdate($request , $id , true);
          return redirect()->back();
     }


    public function getById($id){
        $fields = $this->model->findOrFail($id);
        return $this->createOrEdit('admin.categorie.show' , $id , ['fields' =>  $fields]);
    }

    public function destroy($id){
        return $this->deleteItem($id , 'admin/categorie')->with('sucess' , 'Done Delete categorie From system');
    }

    public function pluck(\Illuminate\Http\Request $request)
    {
        return $this->deleteItem($request->id, 'admin/categorie')->with('sucess', 'Done Delete categorie From system');
    }

}
