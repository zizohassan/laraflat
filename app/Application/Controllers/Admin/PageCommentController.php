<?php

namespace App\Application\Controllers\Admin;

use \App\Application\Requests\Admin\PageComment\AddRequestPageComment;
use \App\Application\Requests\Admin\PageComment\UpdateRequestPageComment;
use App\Application\Controllers\AbstractController;
use App\Application\Model\PageComment;
use App\Application\Model\Page;
use Yajra\Datatables\Request;
use Alert;

class PageCommentController extends AbstractController
{

   public function __construct(PageComment $model , Page $parent)
    {
        parent::__construct($model);
        $this->parent = $parent;
    }

    public function addComment($id , AddRequestPageComment $request){
        $this->parent->findOrFail($id);
        $array = [
            'comment' => $request->comment,
            'user_id' => auth()->user()->id,
            'page_id' => $id
        ];
        $this->model->create($array);
        return redirect('admin/page/'.$id.'/view');
    }

    public function updateComment($id , UpdateRequestPageComment $request){
        $item =  $this->model->findOrFail($id);
        if($item->user_id != auth()->user()->id)
            return redirect('admin/page/'.$item->page_id.'/view');
        $array = [
            'comment' => $request->comment
        ];
        $item->update($array);
        return redirect('admin/page/'.$item->page_id.'/view');
    }

    public function deleteComment($id){
        $item =  $this->model->findOrFail($id);
        if($item->user_id != auth()->user()->id)
            return redirect('admin/page/'.$item->page_id.'/view');
        $item->delete();
        return redirect('admin/page/'.$item->page_id.'/view');
    }


}