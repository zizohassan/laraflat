<?php

namespace App\Application\Requests\Admin\Permission;

use Illuminate\Foundation\Http\FormRequest;

class AddRequestPermission extends FormRequest
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
            'name' => 'required',
            'controller_name' => 'required',
            'permission' => 'required',
            'method_name' => 'required',
            'controller_type' => 'required',
            'slug' => 'required|unique:permissions'
        ];
    }
}
