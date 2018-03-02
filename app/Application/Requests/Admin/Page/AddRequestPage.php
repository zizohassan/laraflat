<?php

namespace App\Application\Requests\Admin\Page;

use Illuminate\Foundation\Http\FormRequest;

class AddRequestPage extends FormRequest
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
            "title.*" => "min:1|max:70|required",
			"body.*" => "min:1|required",
			"active" => "required|integer",
			
        ];
    }

}
