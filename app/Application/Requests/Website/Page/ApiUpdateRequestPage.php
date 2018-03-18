<?php

namespace App\Application\Requests\Website\Page;

use Illuminate\Support\Facades\Route;

class ApiUpdateRequestPage
{
    public function rules()
    {
        $id = Route::input('id');
        return [
            "title.*" => "min:1|max:70|required",
            "body.*" => "min:1|required",
			"active" => "required|integer",
        ];
    }
}
