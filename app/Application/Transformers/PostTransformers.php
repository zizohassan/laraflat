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
			"image[]" => $modelOrCollection->image[],
			"file[]" => $modelOrCollection->file[],
			"home" => $modelOrCollection->home,
			"des" => $modelOrCollection->{lang("des" , "en")},

        ];
    }

    public function transformModelAr(Model $modelOrCollection)
    {
        return [
           "id" => $modelOrCollection->id,
			"title" => $modelOrCollection->{lang("title" , "ar")},
			"image[]" => $modelOrCollection->image[],
			"file[]" => $modelOrCollection->file[],
			"home" => $modelOrCollection->home,
			"des" => $modelOrCollection->{lang("des" , "ar")},

        ];
    }

}