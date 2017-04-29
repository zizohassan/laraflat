<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

  public $table = "menu";

  public $validation = [
        'name' => 'required'
  ];

  protected $fillable = [
        'name'
  ];

  public $timestamps = false;

  public function item(){
     return $this->hasMany('App\Application\Model\Item');
  }

}
