<?php

namespace App\Application\Requests\Website\Page;


class ApiAddRequestPage
{
    public function rules()
    {
        return [
            "title.*" => "min:1|max:70|required",
            "body.*" => "min:1|required",
			"active" => "required|integer",
        ];
    }
}
