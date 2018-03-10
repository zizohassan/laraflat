<?php

namespace App\Application\Controllers\Api;


use App\Application\Controllers\Controller;
use App\Application\Model\Page;
use App\Application\Transformers\PageTransformers;
use App\Application\Requests\Website\Page\ApiAddRequestPage;
use App\Application\Requests\Website\Page\ApiUpdateRequestPage;

class PageApi extends Controller
{

    use ApiTrait;
    protected $model;

    public function __construct(Page $model)
    {
        $this->model = $model;
        /// send header Authorization Bearer token
        /// $this->middleware('authApi')->only();
    }


    public function add(ApiAddRequestPage $validation){
        return $this->addItem($validation);
    }

    public function update($id , ApiUpdateRequestPage $validation){
        return $this->updateItem($id , $validation);
    }


    protected function checkLanguageBeforeReturn($data ,$status_code = 200 ,  $paginate = [])
    {
        if (request()->has('lang') && request()->get('lang') == 'ar') {
            return response(apiReturn(PageTransformers::transformAr($data) + $paginate), $status_code);
        }
        return response(apiReturn(PageTransformers::transform($data) + $paginate), $status_code);
    }

}
