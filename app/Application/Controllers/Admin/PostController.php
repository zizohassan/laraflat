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
        return $this->createOrEdit('admin.post.show' , $id , ['fields' =>  $fields]);
    }

    public function destroy($id){
        return $this->deleteItem($id , 'admin/post')->with('sucess' , 'Done Delete post From system');
    }

    public function pluck(\Illuminate\Http\Request $request){
        return $this->deleteItem($request->id , 'admin/post')->with('sucess' , 'Done Delete post From system');
    }

}
