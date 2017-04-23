<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

  public $table = "setting";

  public $validation = [
        'name' => 'required',
        'type' => 'required',
        'body_setting' => 'required'
   ];

   protected $fillable = [
        'name' ,'type' , 'body_setting'
   ];

    public $timestamps = false;


}
