<?php

namespace App\Application\Controllers\Api;


use App\Application\Controllers\Controller;
use App\Application\Model\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Application\Transformers\CategorieTransformers;
use App\Application\Requests\Website\Categorie\ApiAddRequestCategorie;
use App\Application\Requests\Website\Categorie\ApiUpdateRequestCategorie;

class CategorieApi extends Controller
{

    protected $request;
    protected $model;

    public function __construct(Categorie $model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;
        /// send header Authorization Bearer token
        /// $this->middleware('authApi')->only();
    }


    public function add(ApiAddRequestCategorie $validation)
    {
        $request = $this->checkRequestType();
        $v = Validator::make($this->request->all(), $validation->rules());
        if ($v->fails()) {
            return response(apiReturn('', 'error', $v->errors()), 200);
        }
        $data = $this->model->create(transformArray(checkApiHaveImage($request)));
        return $this->checkLanguageBeforeReturn($data);

    }

    public function update($id, ApiUpdateRequestCategorie $validation)
    {
        $request = $this->checkRequestType();
        $v = Validator::make($this->request->all(), $validation->rules());
        if ($v->fails()) {
            return response(apiReturn('', 'error', $v->errors()), 200);
        }
        $data = $this->model->find($id)->update(transformArray(checkApiHaveImage($request)));
        return response(apiReturn($data), 200);
    }


    protected function checkLanguageBeforeReturn($data)
    {
        if (request()->has('lang') && request()->get('lang') == 'ar') {
            return response(apiReturn(CategorieTransformers::transformAr($data)), 200);
        }
        return response(apiReturn(CategorieTransformers::transform($data)), 200);
    }

}
