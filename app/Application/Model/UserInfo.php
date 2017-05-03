<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{

  public $table = "user_info";

  public $timestamps = false;

   protected $fillable = [
        'ip' , 'iso_code' , 'country' , 'city' , 'state','state_name' , 'postal_code' , 'lat' ,'lon' ,
       'continent' , 'timezone' , 'currency' , 'user_id'
   ];

    public function user(){
        return $this->belongsTo('App\Application\Model\User' , 'user_id');
    }


}
