<?php
 namespace App\Application\Controllers\Website;
 use App\Application\Controllers\AbstractController;
use Alert;
use App\Application\Model\Page;
use App\Application\Requests\Website\Page\AddRequestPage;
use App\Application\Requests\Website\Page\UpdateRequestPage;
 class PageController extends AbstractController
{
      public function __construct(Page $model)
        {
            parent::__construct($model);
        }
         public function index(){
            $items = $this->model->paginate(env('PAGINATE'));
            return view('website.page.index' , compact('items'));
        }
         public function show($id = null){
            return $this->createOrEdit('website.page.edit' , $id);
        }
       public function store(AddRequestPage $request){
          $item =  $this->storeOrUpdate($request , null , true);
          return redirect('page');
     }
      public function update($id , UpdateRequestPage $request){
          $item =  $this->storeOrUpdate($request , $id , true);
          return redirect()->back();
     }
          public function getById($id){
            $fields = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());
            return $this->createOrEdit('website.page.show' , $id , ['fields' =>  $fields]);
        }
         public function destroy($id){
            return $this->deleteItem($id , 'page')->with('sucess' , 'Done Delete Page From system');
        }
  }
