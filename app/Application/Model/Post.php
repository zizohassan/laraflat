<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

  public $table = "post";


   protected $fillable = [
        'title','image','file','home','des'
   ];

	public function getTitleLangAttribute(){
		return is_json($this->title) && is_object(json_decode($this->title)) ?  json_decode($this->title)->{getCurrentLang()}  : $this->title;
	}
	public function getTitleEnAttribute(){
		return is_json($this->title) && is_object(json_decode($this->title)) ?  json_decode($this->title)->en  : $this->title;
	}
	public function getTitleArAttribute(){
		return is_json($this->title) && is_object(json_decode($this->title)) ?  json_decode($this->title)->ar  : $this->title;
	}
	public function getDesLangAttribute(){
		return is_json($this->des) && is_object(json_decode($this->des)) ?  json_decode($this->des)->{getCurrentLang()}  : $this->des;
	}
	public function getDesEnAttribute(){
		return is_json($this->des) && is_object(json_decode($this->des)) ?  json_decode($this->des)->en  : $this->des;
	}
	public function getDesArAttribute(){
		return is_json($this->des) && is_object(json_decode($this->des)) ?  json_decode($this->des)->ar  : $this->des;
	}

}
