<?php

namespace App\Application\Requests\Website\Page;


class ApiAddRequestPage
{
    public function rules()
    {
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
