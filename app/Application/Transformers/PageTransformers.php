<?php

namespace App\Application\Transformers;

use Illuminate\Database\Eloquent\Model;

class PageTransformers extends AbstractTransformer
{

    public function transformModel(Model $modelOrCollection)
    {
        return [
            "id" => $modelOrCollection->id,
			"title" => $modelOrCollection->title_en ,
			"body" => $modelOrCollection->body_en,
			"active" => (bool) $modelOrCollection->active

        ];
    }

    public function transformModelAr(Model $modelOrCollection)
    {
        return [
           "id" => $modelOrCollection->id,
            "title" => $modelOrCollection->title_ar ,
            "body" => $modelOrCollection->body_ar,
			"active" => (bool) $modelOrCollection->active

        ];
    }

}