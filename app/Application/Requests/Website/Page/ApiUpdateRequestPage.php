<?php

namespace App\Application\Requests\Website\Page;

use Illuminate\Support\Facades\Route;

class ApiUpdateRequestPage
{
    public function rules()
    {
        $id = Route::input('id');
        return [
            'title' => 'required',
            'slug' => 'required',
            'body' => 'required',
            'status' => 'required',
            'date' => 'required',
            'image' => 'required',
        ];
    }
}
