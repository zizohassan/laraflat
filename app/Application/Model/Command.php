<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{

  public $table = "command";


   protected $fillable = [
        'name' , 'command' , 'options'
   ];


}
