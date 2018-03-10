<?php

namespace App\Application\Requests\Website\Categorie;

use Illuminate\Support\Facades\Route;

class ApiUpdateRequestCategorie
{
    public function rules()
    {
        $id = Route::input('id');
        return [
            "title.*" => "min:1|max:80|required",
        ];
    }
}
