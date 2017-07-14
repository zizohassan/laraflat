<?php

namespace App\Application\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class AddRequestUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:4|max:40',
            'email' => 'email|unique:users',
            'password' => 'required'
        ];
    }
}
