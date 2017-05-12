<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

  public $table = "logs";


   protected $fillable = [
        'action' , 'model'  , 'status' , 'user_id' , 'messages'
   ];

   public function validation($id){
        return [

        ];
   }

    public function updateValidation($id){
        return [

        ];
    }

   public function user(){
       return $this->belongsTo('App\Application\Model\User' , 'user_id');
   }

}
