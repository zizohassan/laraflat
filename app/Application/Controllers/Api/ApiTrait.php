<?php

namespace App\Application\Controllers\Api;

trait ApiTrait{


    public function index($limit = 10, $offset = 0)
    {
        $data = $this->model->limit($limit)->offset($offset)->get();
        if ($data) {
            return $this->checkLanguageBeforeReturn($data);
        }
        return response(apiReturn('', '', 'No Data Found'), 200);
    }

    public function getById($id)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->checkLanguageBeforeReturn($data);
        }
        return response(apiReturn('', '', 'No Data Found'), 200);
    }


    public function delete($id)
    {
        $data = $this->model->find($id)->delete();
        return response(apiReturn($data), 200);
    }

    protected function checkRequestType()
    {
        return $this->request->getContentType() == "json" ? extractJsonInfo($this->request->getContent()) : $this->request->all();
    }

}