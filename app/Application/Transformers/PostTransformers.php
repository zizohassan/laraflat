<?php

namespace App\Application\Transformers;

use Illuminate\Database\Eloquent\Model;

class PostTransformers extends AbstractTransformer
{

    public function transformModel(Model $modelOrCollection)
    {
        return [
            "id" => $modelOrCollection->id,
			"title" => $modelOrCollection->{lang("title" , "en")},
			"body" => $modelOrCollection->{lang("body" , "en")},
			"active" => $modelOrCollection->active,

        ];
    }

    public function transformModelAr(Model $modelOrCollection)
    {
        return [
           "id" => $modelOrCollection->id,
			"title" => $modelOrCollection->{lang("title" , "ar")},
			"body" => $modelOrCollection->{lang("body" , "ar")},
			"active" => $modelOrCollection->active,

        ];
    }

}