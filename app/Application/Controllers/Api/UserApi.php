<?php

namespace App\Application\Controllers\Api;


use App\Application\Controllers\Controller;
use App\Application\Model\User;
use App\Application\Requests\Website\User\ApiAddRequestUser;
use App\Application\Requests\Website\User\ApiLoginRequest;
use App\Application\Requests\Website\User\ApiUpdateRequestUser;
use App\Application\Transformers\UsersTransformers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserApi extends Controller
{

    use ApiTrait;
    protected $request;
    protected $model;

    public function __construct(User $model , Request $request)
    {
        $this->model = $model;
        $this->request = $request;
        $this->middleware('authApi')->only('update' , 'getUserByToken');
    }


    public function login(ApiLoginRequest $validation)
    {
        $request = $this->validateRequest($validation);
        if(!is_array($request)){
            return $request;
        }
        if (! $token = auth()->attempt($this->request->only(['email' , 'password']))) {
           return response(apiReturn('' , 'error' , 'invalid_credentials')  , 200 );
        }
        $user = $this->model->where('email' , $this->request->email)->first();
        $user->api_token = $this->generateToken();
        $user->save();
        return $this->checkLanguageBeforeReturn($user);
    }

    public function add(ApiAddRequestUser $validation){
        $request = $this->validateRequest($validation);
        if(!is_array($request)){
            return $request;
        }
        $request = $this->request->all();
        $request['group_id'] = env('DEFAULT_GROUP');
        $request['password'] = bcrypt($this->request->password);
        $request['api_token'] = $this->generateToken();
        $data = $this->model->create(checkApiHaveImage($request));
        return $this->checkLanguageBeforeReturn($data , 201);
    }

    public function update(ApiUpdateRequestUser $validation){
        $request = $this->validateRequest($validation);
        if(!is_array($request)){
            return $request;
        }
        $user = auth()->guard('api')->user();
        $request = $this->request->all();
        $request['password'] = bcrypt($this->request->password);
        $data = $user->update(checkApiHaveImage($request));
        return response(apiReturn($data)  , 200 );
    }

    public function getUserByToken(){
        $user = auth()->guard('api')->user();
        return response(apiReturn(UsersTransformers::transform($user))  , 200 );
    }

    public function generateToken(){
       return str_random(60);
    }

    protected function checkLanguageBeforeReturn($data , $status_code = 200,  $paginate = [])
    {
        if (request()->has('lang') && request()->get('lang') == 'ar') {
            return response(apiReturn(UsersTransformers::transformAr($data) + $paginate), $status_code);
        }
        return response(apiReturn(UsersTransformers::transform($data) + $paginate), $status_code);
    }

}
