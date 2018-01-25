<?php
 namespace App\Application\Model;
 use Illuminate\Database\Eloquent\Model;
 class PageComment extends Model
{
   public $table = "pagecomment";
   public function user(){
		return $this->belongsTo(User::class, "user_id");
		}
  public function page(){
  return $this->belongsTo(Page::class, "page_id");
  }
    protected $fillable = [
        '','user_id','page_id','comment'
   ];
 }
