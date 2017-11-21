<?php
 namespace App\Application\Model;
 use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
 class User extends Authenticatable
{
    use Notifiable;
     public $table = "users";
     public function post(){
		return $this->belongsToMany( Post::class, "user_post", "user_id" , "post_id");
		}
      protected $fillable = [
        'name', 'email', 'password', 'group_id' ,'api_token'
    ];
     protected $hidden = [
        'password', 'remember_token',
    ];
     public function permission(){
        return $this->belongsToMany('App\Application\Model\Permission' , 'permission_user');
    }
     public function role(){
        return $this->belongsToMany('App\Application\Model\Role' , 'role_user');
    }
     public function group(){
        return $this->belongsTo('App\Application\Model\Group');
    }
  }
