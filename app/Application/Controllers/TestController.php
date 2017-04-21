<?php

namespace App\Application\Controllers;

use App\Application\Model\User;
use Illuminate\Support\Facades\Request;

class TestController extends AbstractController
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function index(){
        return $this->GetAll('welcome');
    }

    public function store($id = null , Request $request){
        return $this->storeOrUpdate($request->all(), $id);
    }

    public function delete($id){
        return $this->deleteItem($id);
    }
}
