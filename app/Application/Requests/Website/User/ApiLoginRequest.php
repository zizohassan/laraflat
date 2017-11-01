<?php

namespace App\Application\Requests\Website\User;


class ApiLoginRequest
{

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|max:255',
        ];
    }
}
