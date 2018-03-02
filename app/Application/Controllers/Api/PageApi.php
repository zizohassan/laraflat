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
        $request = $this->checkRequestType();
        $v = Validator::make($this->request->all(), $validation->rules());
        if ($v->fails()) {
            return response(apiReturn('', 'error', $v->errors()), 200);
        }
        $data = $this->model->create(transformArray(checkApiHaveImage($request)));
        return $this->checkLanguageBeforeReturn($data);
    }

    public function update($id, ApiUpdateRequestPage $validation)
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
            return response(apiReturn(PageTransformers::transformAr($data)), 200);
        }
        return response(apiReturn(PageTransformers::transform($data)), 200);
    }

}
