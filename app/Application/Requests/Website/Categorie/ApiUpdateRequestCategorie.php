<?php

namespace App\Application\Requests\Website\Categorie;

use Illuminate\Support\Facades\Route;

class ApiUpdateRequestCategorie
{
    public function rules()
    {
        $id = Route::input('id');
        return [
            'name' => 'required'
        ];
    }
}
