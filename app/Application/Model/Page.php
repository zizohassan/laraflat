<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

  public $table = "pages";



   protected $fillable = [
        'title' , 'body' , 'date' , 'slug' , 'status','image'
   ];

    public function   validation ($id){
         return  [
            'title.*' => 'required|max:90',
            'body.*' => 'required|min:20',
            'date' => 'required',
            'status' => 'required',
            'image' => 'image',
            'slug' => "required|unique:pages,slug,".$id
           ];
    }

    public function   updateValidation ($id){
        return  [
            'title.*' => 'required|max:90',
            'body.*' => 'required|min:20',
            'date' => 'required',
            'status' => 'required',
            'image' => 'image',
            'slug' => "required|unique:pages,slug,".$id
        ];
    }


}
