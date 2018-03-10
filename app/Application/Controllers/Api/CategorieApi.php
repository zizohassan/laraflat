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

    use ApiTrait;
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
        $request = $this->validateRequest($validation);
        if(!is_array($request)){
            return $request;
        }
        $data = $this->model->create(transformArray(checkApiHaveImage($request)));
        return $this->checkLanguageBeforeReturn($data , 201);
    }

    public function update($id, ApiUpdateRequestCategorie $validation)
    {
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


    protected function checkLanguageBeforeReturn($data , $status_code = 200)
    {
        if (request()->has('lang') && request()->get('lang') == 'ar') {
            return response(apiReturn(CategorieTransformers::transformAr($data)), $status_code);
        }
        return response(apiReturn(CategorieTransformers::transform($data)), $status_code);
    }

}
