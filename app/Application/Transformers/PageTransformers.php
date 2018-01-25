<?php

namespace App\Application\Transformers;

use Illuminate\Database\Eloquent\Model;

class PageTransformers extends AbstractTransformer
{

    public function transformModel(Model $modelOrCollection)
    {
        return [
            "id" => $modelOrCollection->id,
			"title" => getLangValue($modelOrCollection->title , "en")
			"body" => getLangValue($modelOrCollection->body , "en"),
			"active" => $modelOrCollection->active

        ];
    }

    public function transformModelAr(Model $modelOrCollection)
    {
        return [
           "id" => $modelOrCollection->id,
			"title" => getLangValue($modelOrCollection->title , "ar")
			"body" => getLangValue($modelOrCollection->body , "ar"),
			"active" => $modelOrCollection->active

        ];
    }

}