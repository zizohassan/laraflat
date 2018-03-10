<?php

namespace App\Application\Controllers\Api;

use Illuminate\Support\Facades\Validator;

trait ApiTrait{


    public function index()
    {
        $limit = request()->has('limit') &&  (int) request()->get('limit') != 0 && (int) request()->get('limit') < 30 ? request()->get('limit') : env('PAGINATE');
        $data = $this->model->orderBy('id' , 'desc')->paginate($limit);
        if ($data) {
            return $this->checkLanguageBeforeReturn($data , 200 , $this->paginateArray($data));
        }
        return response(apiReturn('', '', 'No Data Found'), 200);
    }

    public function getById($id)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->checkLanguageBeforeReturn($data);
        }
        return response(apiReturn('', '', 'No Data Found'), 404);
    }


    public function delete($id)
    {
        $data = $this->model->find($id)->delete();
        return response(apiReturn($data), 200);
    }

    protected function checkRequestType()
    {
        return request()->getContentType() == "json" ? extractJsonInfo(request()->getContent()) : request()->all();
    }

    protected function validateRequest($validation){
        $request = $this->checkRequestType();
        $v = Validator::make($request, $validation->rules());
        if ($v->fails()) {
            return response(apiReturn('', 'error', $v->errors()), 422);
        }
        return $request;
    }

    protected function updateItem($id , $validation){
        $request = $this->validateRequest($validation);
        if(!is_array($request)){
            return $request;
        }
        $data = $this->model->find($id);
        if($data){
            $data->update(transformArray(checkApiHaveImage($request)));
            return $this->checkLanguageBeforeReturn($data , 201);
        }
        return response(apiReturn('' , 'error' , 'Not Found !'), 404);
    }

    protected function addItem($validation){
        $request = $this->validateRequest($validation);
        if(!is_array($request)){
            return $request;
        }
        $data = $this->model->create(transformArray(checkApiHaveImage($request)));
        return $this->checkLanguageBeforeReturn($data , 201);
    }


    protected function paginateArray($data){
        return [
            "total_count" => $data->total(),
            "total_pages" => ceil($data->total() / $data->perPage()),
            "current_page" => $data->currentPage(),
            "limit" => $data->perPage()
        ];
    }

}