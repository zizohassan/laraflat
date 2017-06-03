<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

  public $table = "menu";

  protected $fillable = [
        'name'
  ];

  public function   validation ($id){
    return [
        'name' => 'required|unique:menu,name,'.$id
    ];
  }
  public function   updateValidation ($id){
    return [
        'name' => 'required|unique:menu,name,'.$id
    ];
  }


  public function item(){
     return $this->hasMany('App\Application\Model\Item');
  }

}
