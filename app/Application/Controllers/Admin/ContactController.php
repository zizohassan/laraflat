<?php

namespace App\Application\Controllers\Admin;

use App\Application\Requests\Admin\Contact\AddRequestContact;
use App\Application\Requests\Admin\Contact\UpdateRequestContact;
use App\Application\Controllers\AbstractController;
use App\Application\DataTables\ContactsDataTable;
use App\Application\Model\Contact;
use App\Mail\ReplayContact;
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Request;
use Alert;

class ContactController extends AbstractController
{
    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }

    public function replayEmail($id , \Illuminate\Http\Request $request){
         $item  = $this->model->find($id);
         Mail::to($item->email)->send(new ReplayContact($item , $request->replay));
        alert()->success('sucess' , 'Done Replay');
        return redirect()->back();
    }

    public function index(ContactsDataTable $dataTable){
        return $dataTable->render('admin.contact.index');
    }

    public function show($id = null){
        return $this->createOrEdit('admin.contact.edit' , $id);
    }

    public function store(AddRequestContact $request){
         return $this->storeOrUpdate($request , null , 'admin/contact');
    }

    public function update($id , UpdateRequestContact $request){
             return $this->storeOrUpdate($request , $id , 'admin/contact');
    }

    public function getById($id){
        $fields = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());
        return $this->createOrEdit('admin.contact.show' , $id , ['fields' =>  $fields]);
    }

    public function destroy($id){
        return $this->deleteItem($id , 'admin/contact')->with('sucess' , 'Done Delete contact From system');
    }

    public function pluck(\Illuminate\Http\Request $request){
        return $this->deleteItem($request->id , 'admin/contact')->with('sucess' , 'Done Delete contact From system');
    }


}
