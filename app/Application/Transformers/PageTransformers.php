<?php

namespace App\Application\Transformers;

use Illuminate\Database\Eloquent\Model;

class PageTransformers extends AbstractTransformer
{

    public function transformModel(Model $modelOrCollection)
    {
        return [
            'id' => $modelOrCollection->id,
            'name' => getLangValue($modelOrCollection->title , 'en'),
            'slug' => $modelOrCollection->slug,
            'body' => getLangValue($modelOrCollection->body , 'en'),
            'status' => $modelOrCollection->status,
            'date' => $modelOrCollection->date,
            'image' => url(env('UPLOAD_PATH').'/'.$modelOrCollection->image),
        ];
    }

    public function transformModelAr(Model $modelOrCollection)
    {
        return [
            'id' => $modelOrCollection->id,
            'name' => getLangValue($modelOrCollection->title , 'ar'),
            'slug' => $modelOrCollection->slug,
            'body' => getLangValue($modelOrCollection->body , 'ar'),
            'status' => $modelOrCollection->status,
            'date' => $modelOrCollection->date,
            'image' => url(env('UPLOAD_PATH').'/'.$modelOrCollection->image),
        ];
    }

}