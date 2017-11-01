<?php

namespace App\Application\Requests\Website\User;

use Illuminate\Support\Facades\Route;

class ApiUpdateRequestUser
{

    public function rules()
    {
        $id = Route::input('id');
        return [
              'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,'.$id,
            'password' => 'required|min:6|confirmed',
        ];
    }
}
