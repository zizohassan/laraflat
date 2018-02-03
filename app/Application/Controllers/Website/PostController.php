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

			if(request()->has("home") && request()->get("home") != ""){
				$items = $items->where("home","=", request()->get("home"));
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
          if ($request->has("oldFiles_image") && $request->oldFiles_image != "") {
                                        $oldImage_image = $request->oldFiles_image;
                                        $request->request->remove("oldFiles_image");
                                    } else {
                                        $oldImage_image = json_encode([]);
                                    }
if ($request->has("oldFiles_file") && $request->oldFiles_file != "") {
                                        $oldImage_file = $request->oldFiles_file;
                                        $request->request->remove("oldFiles_file");
                                    } else {
                                        $oldImage_file = json_encode([]);
                                    }
$item = $this->storeOrUpdate($request, $id, true);
if ($item) {
                                    $image = json_decode($item->image) ?? [];
                                    $newIamge = json_decode($oldImage_image) ?? [];
                                    $item_image = array_unique(array_merge($image, $newIamge));
                                    $item->image = json_encode($item_image);
                                    $item->save();
                                }
if ($item) {
                                    $image = json_decode($item->file) ?? [];
                                    $newIamge = json_decode($oldImage_file) ?? [];
                                    $item_image = array_unique(array_merge($image, $newIamge));
                                    $item->file = json_encode($item_image);
                                    $item->save();
                                }
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
