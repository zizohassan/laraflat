<?php

namespace App\Application\Requests\Website\Categorie;

use Illuminate\Foundation\Http\FormRequest;

class ApiAddRequestCategorie
{
    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }
}
