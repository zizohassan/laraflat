<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $table = "items";
    public $timestamps = false;
    public $validation = [
        'name' =>'required|unique:items',
        'link' => 'required',
        'type' => 'required',
        'parent_id' => 'required',
        'menu_id' =>'required',
        'order' => 'required'
    ];
    protected $fillable = [
        'name' , 'link' , 'type', 'parent_id', 'menu_id', 'order','icon'
    ];
    public function menu(){
        return $this->belongsTo('App\Menu' , 'menu_id');
    }


}
