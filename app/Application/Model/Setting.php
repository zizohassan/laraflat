<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

  public $table = "setting";

   protected $fillable = [
        'name' ,'type' , 'body_setting'
   ];


}
