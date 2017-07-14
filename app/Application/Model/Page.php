<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

  public $table = "pages";



   protected $fillable = [
        'title' , 'body' , 'date' , 'slug' , 'status','image'
   ];

    public function   validation ($id){
         return  [

           ];
    }

    public function   updateValidation ($id){
        return  [

        ];
    }


}
