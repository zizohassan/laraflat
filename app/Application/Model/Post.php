<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

  public $table = "post";


   protected $fillable = [
        'title','t','image','photo','file','files','date','icon','url','lng','lat','youtube','active'
   ];


}
