<?php
 namespace App\Application\Model;
 use Illuminate\Database\Eloquent\Model;
 class Categorie extends Model
{
   public $table = "categorie";
   public function post(){
		return $this->hasOne(Post::class, "categorie_id");
		}
    protected $fillable = [
        'title'
   ];
 }
