<?php

namespace App\Application\Transformers;

use Illuminate\Database\Eloquent\Model;

 class UsersTransformers extends AbstractTransformer
{
     public function transformModel(Model $modelOrCollection)
     {
         return [
             'id' => $modelOrCollection->id,
             'name' => $modelOrCollection->name,
             'email' => $modelOrCollection->email,
             'token' => $modelOrCollection->api_token,
         ];
     }
 }