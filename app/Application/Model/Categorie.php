<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{

  public $table = "categories";

  public $timestamps = false;

   protected $fillable = [
        'name'
   ];

   public function validation($id){
        return [
            'name' => 'required|max:50|min:3|unique:categories,name,'.$id
        ];
   }

}
