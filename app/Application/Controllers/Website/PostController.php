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
				$items = $items->where("title","=", request()->get("title"));
			}

			if(request()->has("t") && request()->get("t") != ""){
				$items = $items->where("t","like", "%".request()->get("t")."%");
			}

			if(request()->has("date") && request()->get("date") != ""){
				$items = $items->where("date","=", request()->get("date"));
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
          if ($request->has("oldFiles_photo") && $request->oldFiles_photo != "") {
                                        $oldImage_photo = $request->oldFiles_photo;
                                        $request->request->remove("oldFiles_photo");
                                    } else {
                                        $oldImage_photo = json_encode([]);
                                    }
if ($request->has("oldFiles_files") && $request->oldFiles_files != "") {
                                        $oldImage_files = $request->oldFiles_files;
                                        $request->request->remove("oldFiles_files");
                                    } else {
                                        $oldImage_files = json_encode([]);
                                    }
$item = $this->storeOrUpdate($request, $id, true);
if ($item) {
                                    $image = json_decode($item->photo) ?? [];
                                    $newIamge = json_decode($oldImage_photo) ?? [];
                                    $item_image = array_unique(array_merge($image, $newIamge));
                                    $item->photo = json_encode($item_image);
                                    $item->save();
                                }
if ($item) {
                                    $image = json_decode($item->files) ?? [];
                                    $newIamge = json_decode($oldImage_files) ?? [];
                                    $item_image = array_unique(array_merge($image, $newIamge));
                                    $item->files = json_encode($item_image);
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
