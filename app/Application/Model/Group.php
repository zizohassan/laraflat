<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

  public $table = "groups";

   protected $fillable = [
        'name' , 'slug' , 'description'
   ];



  public function user(){
        return $this->hasMany('App\Application\Model\User', 'group_id');
  }

  public function permission(){
        return $this->belongsToMany('App\Application\Model\Permission'  , 'permission_group');
  }

  public function role(){
        return $this->belongsToMany('App\Application\Model\Role' , 'group_role');
  }




}
