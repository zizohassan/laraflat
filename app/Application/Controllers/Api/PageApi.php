<?php

namespace App\Application\Controllers\Api;


use App\Application\Controllers\Controller;
use App\Application\Model\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Application\Transformers\PageTransformers;
use App\Application\Requests\Website\Page\ApiAddRequestPage;
use App\Application\Requests\Website\Page\ApiUpdateRequestPage;

class PageApi extends Controller
{

    use ApiTrait;

    protected $request;
    protected $model;

    public function __construct(Page $model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;
        /// send header Authorization Bearer token
        /// $this->middleware('authApi')->only();
    }

    public function add(ApiAddRequestPage $validation)
    {
        $request = $this->validateRequest($validation);
        if(!is_array($request)){
            return $request;
        }
        $data = $this->model->create(transformArray(checkApiHaveImage($request)));
        return $this->checkLanguageBeforeReturn($data , 201);
    }


    public function update($id, ApiUpdateRequestPage $validation)
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


    protected function checkLanguageBeforeReturn($data ,$status_code = 200)
    {
        if (request()->has('lang') && request()->get('lang') == 'ar') {
            return response(apiReturn(PageTransformers::transformAr($data)), $status_code);
        }
        return response(apiReturn(PageTransformers::transform($data)), $status_code);
    }

}
