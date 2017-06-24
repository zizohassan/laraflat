<?php

namespace App\Application\Controllers\Api;


use App\Application\Controllers\Controller;
use App\Application\Model\User;
use App\Application\Transformers\UsersTransformers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserApi extends Controller
{

    protected $request;
    protected $model;

    public function __construct(User $model , Request $request)
    {
        $this->model = $model;
        $this->request = $request;
        $this->middleware('authApi')->only('update' , 'getUserByToken');
    }

    public function index($limit = 10 , $offset = 0){
       $data =  $this->model->limit($limit)->offset($offset)->get();
        return response(apiReturn(UsersTransformers::transform($data)) , 200 );
    }

    public function getById($id){
        $data =  $this->model->find($id);
        return response(apiReturn(UsersTransformers::transform($data)) , 200 );
    }

    public function login()
    {
        $v = Validator::make($this->request->all(), $this->model->loginValidation());
        if ($v->fails()) {
            return response(apiReturn('' , 'error' , $v->errors())  , 401 );
        }
        if (! $token = auth()->attempt($this->request->only(['email' , 'password']))) {
           return response(apiReturn('' , 'error' , 'invalid_credentials')  , 401 );
        }
        $user = $this->model->where('email' , $this->request->email)->first();
        $user->api_token = $this->generateToken();
        $user->save();
        return response(apiReturn($user)  , 200 );
    }

    public function add(){
        $v = Validator::make($this->request->all(), $this->model->validation(null));
        if ($v->fails()) {
            return response(apiReturn('' , 'error' , $v->errors())  , 401 );
        }
        $request = $this->request->all();
        $request['group_id'] = env('DEFAULT_GROUP');
        $request['password'] = bcrypt($this->request->password);
        $request['api_token'] = $this->generateToken();
        $data = $this->model->create(checkApiHaveImage($request));
        return response(apiReturn(UsersTransformers::transform($data))  , 200 );
    }

    public function update(){
        $v = Validator::make($this->request->all(), $this->model->updateValidation(null));
        if ($v->fails()) {
            return response(apiReturn('' , 'error' , $v->errors())  , 401 );
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

    public function delete($id){
        $data = $this->model->find($id)->delete();
        return response(apiReturn($data)  , 200 );
    }

    public function generateToken(){
       return str_random(60);
    }

}
