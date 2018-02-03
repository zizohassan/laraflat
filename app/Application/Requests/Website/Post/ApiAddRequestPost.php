<?php

namespace App\Application\Requests\Website\Post;


class ApiAddRequestPost
{
    public function rules()
    {
        return [
            "title.*" => "image[]",
			"des.*" => "",
			
        ];
    }
}
