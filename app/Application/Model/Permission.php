<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

  public $table = "permissions";

  protected $fillable = [
        'name' , 'slug'  , 'controller_name' , 'description' ,'method_name' , 'controller_type' , 'permission' , 'namespace'
  ];

  public function user(){
        return $this->belongsToMany('App\Application\Model\User', 'permission_user');
  }

  public function group(){
        return $this->belongsToMany('App\Application\Model\Group' , 'permission_group');
  }

  public function role(){
        return $this->belongsToMany('App\Application\Model\Role' , 'permission_role');
  }


}
