<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

  public $table = "contacts";

   protected $fillable = [
       'name', 'email', 'subject', 'phone', 'message' ,'user_id'
   ];


    public function user(){
        return $this->belongsTo('App\Application\Model\User' , 'user_id');
    }



}
