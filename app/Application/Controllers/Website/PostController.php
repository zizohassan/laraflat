<?php

namespace App\Application\Controllers\Website;

use App\Application\Controllers\AbstractController;
use Alert;
use App\Application\Model\Post;
use App\Application\Requests\Website\Post\AddRequestPost;
use App\Application\Requests\Website\Post\UpdateRequestPost;

class PostController extends AbstractController
{

     public function __construct(Post $model)
        {
            parent::__construct($model);
        }

        public function index(){
            $items = $this->model;

            if(request()->has('from') && request()->get('from') != ''){
                $items = $items->whereDate('created_at' , '>=' , request()->get('from'));
            }

            if(request()->has('to') && request()->get('to') != ''){
                $items = $items->whereDate('created_at' , '<=' , request()->get('to'));
            }

			if(request()->has("title") && request()->get("title") != ""){
				$items = $items->where("title","like", "%".request()->get("title")."%");
			}

			if(request()->has("active") && request()->get("active") != ""){
				$items = $items->where("active","=", request()->get("active"));
			}



            $items = $items->paginate(env('PAGINATE'));
            return view('website.post.index' , compact('items'));
        }

        public function show($id = null){
            return $this->createOrEdit('website.post.edit' , $id);
        }


     public function store(AddRequestPost $request){
          $item =  $this->storeOrUpdate($request , null , true);
          return redirect('post');
     }

     public function update($id , UpdateRequestPost $request){
          $item = $this->storeOrUpdate($request, $id, true);
return redirect()->back();

     }


        public function getById($id){
            $fields = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());
            return $this->createOrEdit('website.post.show' , $id , ['fields' =>  $fields]);
        }

        public function destroy($id){
            return $this->deleteItem($id , 'post')->with('sucess' , 'Done Delete Post From system');
        }


}
