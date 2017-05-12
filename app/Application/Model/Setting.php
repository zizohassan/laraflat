<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

  public $table = "setting";

  public function   validation ($id){
        return [
            'name' => 'required|unique:setting,name,'.$id,
            'type' => 'required',
            'body_setting' => 'required'
        ];
  }

    public function   updateValidation ($id){
        return [
            'name' => 'required|unique:setting,name,'.$id,
            'type' => 'required',
            'body_setting' => 'required'
        ];
    }

   protected $fillable = [
        'name' ,'type' , 'body_setting'
   ];

    public $timestamps = false;


}
