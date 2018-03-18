<?php

namespace App\Application\Controllers\Admin;

use App\Application\Requests\Admin\Page\AddRequestPage;
use App\Application\Requests\Admin\Page\UpdateRequestPage;
use App\Application\Controllers\AbstractController;
use App\Application\DataTables\PagesDataTable;
use App\Application\Model\Page;
use Yajra\Datatables\Request;
use Alert;

class PageController extends AbstractController
{
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    public function index(PagesDataTable $dataTable)
    {
        return $dataTable->render('admin.page.index');
    }

    public function show($id = null)
    {
        return $this->createOrEdit('admin.page.edit', $id);
    }

    public function store(AddRequestPage $request)
    {
        $item = $this->storeOrUpdate($request, null, true);
        return redirect('admin/page');
    }

    public function update($id, UpdateRequestPage $request)
    {
        $item = $this->storeOrUpdate($request, $id, true);
        return redirect()->back();
    }

    public function getById($id)
    {
        $fields = $this->model->findOrFail($id);
        return $this->createOrEdit('admin.page.show', $id, ['fields' => $fields]);
    }

    public function destroy($id)
    {
        return $this->deleteItem($id, 'admin/page')->with('sucess', 'Done Delete page From system');
    }

    public function pluck(\Illuminate\Http\Request $request){
        return $this->deleteItem($request->id , 'admin/page')->with('sucess' , 'Done Delete page From system');
    }
}
