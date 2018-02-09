<?php

namespace App\Application\Transformers;

use Illuminate\Database\Eloquent\Model;

class PostTransformers extends AbstractTransformer
{

    public function transformModel(Model $modelOrCollection)
    {
        return [
            "id" => $modelOrCollection->id,
			"title" => $modelOrCollection->title,
			"t[]" => $modelOrCollection->t[],
			"image" => $modelOrCollection->image,
			"photo[]" => $modelOrCollection->photo[],
			"file" => $modelOrCollection->file,
			"files[]" => $modelOrCollection->files[],
			"date" => $modelOrCollection->date,
			"icon" => $modelOrCollection->icon,
			"url" => $modelOrCollection->url,
			"lng" => $modelOrCollection->lng,
			"lat" => $modelOrCollection->lat,
			"youtube" => $modelOrCollection->youtube,
			"active" => $modelOrCollection->active,

        ];
    }

    public function transformModelAr(Model $modelOrCollection)
    {
        return [
           "id" => $modelOrCollection->id,
			"title" => $modelOrCollection->title,
			"t[]" => $modelOrCollection->t[],
			"image" => $modelOrCollection->image,
			"photo[]" => $modelOrCollection->photo[],
			"file" => $modelOrCollection->file,
			"files[]" => $modelOrCollection->files[],
			"date" => $modelOrCollection->date,
			"icon" => $modelOrCollection->icon,
			"url" => $modelOrCollection->url,
			"lng" => $modelOrCollection->lng,
			"lat" => $modelOrCollection->lat,
			"youtube" => $modelOrCollection->youtube,
			"active" => $modelOrCollection->active,

        ];
    }

}