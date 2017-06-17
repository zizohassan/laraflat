<?php

namespace App\Application\Transformers;

use Illuminate\Database\Eloquent\Model;

class CategorieTransformers extends AbstractTransformer
{

    public function transformModel(Model $modelOrCollection)
    {
        return [
            'id' => $modelOrCollection->id,
            'name' => getLangValue($modelOrCollection->name , 'en'),
        ];
    }

    public function transformModelAr(Model $modelOrCollection)
    {
        return [
            'id' => $modelOrCollection->id,
            'name' => getLangValue($modelOrCollection->name , 'ar'),
        ];
    }

}