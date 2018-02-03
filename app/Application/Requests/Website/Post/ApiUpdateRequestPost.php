<?php

namespace App\Application\Requests\Website\Post;

use Illuminate\Support\Facades\Route;

class ApiUpdateRequestPost
{
    public function rules()
    {
        $id = Route::input('id');
        return [
            "title.*" => "image[]",
			"des.*" => "",
			
        ];
    }
}
