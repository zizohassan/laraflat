<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{

  public $table = "relations";


   protected $fillable = [
        'name' , 'command' , 'options' , 'p' , 'f' , 't'
   ];


}
