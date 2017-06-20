<?php

namespace App\Application\Controllers\Api;


use App\Application\Controllers\Controller;
use App\Application\Model\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Application\Transformers\PageTransformers;

class PageApi extends Controller
{

    protected $request;
    protected $model;

    public function __construct(Page $model , Request $request)
    {
        $this->model = $model;
        $this->request = $request;
        /// send header Authorization Bearer token
        /// $this->middleware('authApi')->only();
    }

    public function index($limit = 10 , $offset = 0, $lang = "en"){
       $data =  $this->model->limit($limit)->offset($offset)->get();
       return response(apiReturn(PageTransformers::transform($data))  , 200 );
    }

    public function getById($id, $lang = "en"){
        $data =  $this->model->find($id);
        return response(apiReturn(PageTransformers::transform($data))  , 200 );
    }

    public function add(){
        $request = $this->checkRequestType();
        $v = Validator::make($request, $this->model->validation(null));
        if ($v->fails()) {
            return response(apiReturn('' , 'error'  , $v->errors())  , 401 );
        }
        $data = $this->model->create(transformArray(checkApiHaveImage($request)));
        return response(apiReturn(PageTransformers::transform($data))  , 200 );

    }

    public function update($id){
        $request = $this->checkRequestType();
        $v = Validator::make($request, $this->model->updateValidation($id));
        if ($v->fails()) {
            return response(apiReturn('' , 'error'  , $v->errors())  , 401 );
        }
        $data = $this->model->find($id)->update(transformArray(checkApiHaveImage($request)));
         return response(apiReturn($data)  , 200 );
    }

    public function delete($id){
        $data = $this->model->find($id)->delete();
        return response(apiReturn($data)  , 200 );
    }

    protected function checkRequestType(){
        return $this->request->getContentType() == "json" ? extractJsonInfo($this->request->getContent()) : $this->request->all();
    }

}
