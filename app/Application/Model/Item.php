<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $table = "items";

    protected $fillable = [
        'name', 'link', 'type', 'parent_id', 'menu_id', 'order', 'icon', 'controller_path'
    ];

    public function validation($id)
    {
        return [
            'name*name' => 'required|unique:items,name,' . $id,
            'link' => 'required',
            'type' => 'required',
            'parent_id' => 'required',
            'menu_id' => 'required',
            'order' => 'required'
        ];
    }

    public function updateValidation($id)
    {
        return [
            'name*name' => 'required|unique:items,name,' . $id,
            'link' => 'required',
            'type' => 'required',
            'parent_id' => 'required',
            'menu_id' => 'required',
            'order' => 'required'
        ];
    }

    public function menu()
    {
        return $this->belongsTo('App\Menu', 'menu_id');
    }


}
