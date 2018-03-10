<?php

namespace App\Application\Requests\Website\Categorie;


class ApiAddRequestCategorie
{
    public function rules()
    {
        return [
            "title.*" => "min:1|max:80|required",
        ];
    }
}
