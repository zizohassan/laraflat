<?php
 namespace App\Application\Model;
 use Illuminate\Database\Eloquent\Model;
 class Categorie extends Model
{
   public $table = "categorie";
    protected $fillable = [
        'title'
   ];
 }
