<?php
 namespace App\Application\Model;
 use Illuminate\Database\Eloquent\Model;
 class Page extends Model
{
   public $table = "page";
  public function pagecomment(){
		return $this->hasMany(PageComment::class, "page_id");
		}
    protected $fillable = [
        'title','body','active'
   ];
 }
