<?php

namespace App\Application\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username','email', 'password', 'group_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function   validation ($id){
        return [
            'name' => 'required|min:4|max:40',
            'username' => 'required|alpha_dash|unique:users',
            'email' => 'email|unique:users,email,'.$id,
            'password' => 'required'
        ];
    }

    public function   updateValidation ($id){
        return [
            'name' => 'required|min:4|max:40',
            'username' => 'required|alpha_dash|unique:users,username,'.$id,
            'email' => 'email|unique:users,email,'.$id,
            'password' => 'required'
        ];
    }
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
