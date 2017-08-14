<?php

namespace App\Application\Controllers\Admin;

use App\Application\Controllers\AbstractController;
use App\Application\DataTables\PagesDataTable;
use App\Application\Model\Page;
use App\Application\Repository\InterFaces\PageInterface;
use App\Application\Requests\Admin\Page\AddRequestPage;
use App\Application\Requests\Admin\Page\UpdateRequestPage;
use Yajra\Datatables\Request;
use Alert;

class PageController extends AbstractController
{

    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    public function index(PagesDataTable $dataTable){
        return $dataTable->render('admin.page.index');
    }

    public function show($id = null){
        return $this->createOrEdit('admin.page.edit' , $id);
    }

    public function store(AddRequestPage $request){
         return $this->storeOrUpdate($request , null , 'admin/page');
    }

    public function update($id  , UpdateRequestPage $request){
        return $this->storeOrUpdate($request , $id , 'admin/page');
    }

    public function getById($id){
        $fields = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());
        return $this->createOrEdit('admin.page.show' , $id , ['fields' =>  $fields]);
    }

    public function destroy($id){
        return $this->deleteItem($id , 'admin/page')->with('sucess' , 'Done Delete page From system');
    }
}
