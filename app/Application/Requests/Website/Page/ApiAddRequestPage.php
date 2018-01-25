<?php

namespace App\Application\Requests\Website\Page;


class ApiAddRequestPage
{
    public function rules()
    {
        return [
            "title.*" => "min:1|max:70|requiredbody.*",
			"active" => "required|integer",
			
        ];
    }
}
