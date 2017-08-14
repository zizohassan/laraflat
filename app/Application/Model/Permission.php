<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

  public $table = "permissions";

  protected $fillable = [
        'name' , 'slug' , 'action_add' , 'action_edit', 'action_view', 'action_delete' , 'model' , 'description'
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
