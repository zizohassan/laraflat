<?php
 namespace App\Application\Model;
 use Illuminate\Database\Eloquent\Model;
 class Role extends Model
{
   public $table = "roles";
    protected $fillable = [
        'name' , 'slug' , 'description'
   ];
   public function user(){
      return $this->belongsToMany('App\Application\Model\User' , 'role_user');
  }
    public function group(){
        return $this->belongsToMany('App\Application\Model\Group' , 'group_role');
  }
   public function permission(){
       return $this->belongsToMany('App\Application\Model\Permission' , 'permission_role');
  }
 }
