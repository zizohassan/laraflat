<?php

namespace App\Application\Controllers\Api;


use App\Application\Controllers\Controller;
use App\Application\Model\Categorie;
use App\Application\Transformers\CategorieTransformers;
use App\Application\Requests\Website\Categorie\ApiAddRequestCategorie;
use App\Application\Requests\Website\Categorie\ApiUpdateRequestCategorie;

class CategorieApi extends Controller
{

    use ApiTrait;
    protected $model;

    public function __construct(Categorie $model)
    {
        $this->model = $model;
        /// send header Authorization Bearer token
        /// $this->middleware('authApi')->only();
    }

    public function add(ApiAddRequestCategorie $validation){
        return $this->addItem($validation);
    }

    public function update($id , ApiUpdateRequestCategorie $validation){
        return $this->updateItem($id , $validation);
    }

    protected function checkLanguageBeforeReturn($data , $status_code = 200 , $paginate = [])
    {
        if (request()->has('lang') && request()->get('lang') == 'ar') {
            return response(apiReturn(CategorieTransformers::transformAr($data) + $paginate), $status_code);
        }
        return response(apiReturn(CategorieTransformers::transform($data)+ $paginate), $status_code);
    }

}
