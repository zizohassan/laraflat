<?php

namespace App\Application\Controllers\Admin;

use App\Application\Requests\Admin\Post\AddRequestPost;
use App\Application\Requests\Admin\Post\UpdateRequestPost;
use App\Application\Controllers\AbstractController;
use App\Application\DataTables\PostsDataTable;
use App\Application\Model\Post;
use Yajra\Datatables\Request;
use Alert;

class PostController extends AbstractController
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function index(PostsDataTable $dataTable){
        return $dataTable->render('admin.post.index');
    }

    public function show($id = null){
        return $this->createOrEdit('admin.post.edit' , $id);
    }

     public function store(AddRequestPost $request){
          $item =  $this->storeOrUpdate($request , null , true);
          return redirect('admin/post');
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
        return $this->createOrEdit('admin.post.show' , $id , ['fields' =>  $fields]);
    }

    public function destroy($id){
        return $this->deleteItem($id , 'admin/post')->with('sucess' , 'Done Delete post From system');
    }

    public function pluck(\Illuminate\Http\Request $request){
        return $this->deleteItem($request->id , 'admin/post')->with('sucess' , 'Done Delete post From system');
    }

}
