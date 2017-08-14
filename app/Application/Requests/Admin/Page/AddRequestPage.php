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
            'title.*' => 'required|max:90',
            'body.*' => 'required|min:20',
            'date' => 'required',
            'status' => 'required',
            'image' => 'image',
            'slug' => "required|unique:pages"
        ];
    }
}
