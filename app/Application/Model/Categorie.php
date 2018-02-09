<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    public $table = "categorie";
    protected $fillable = [
        'title'
    ];

    public function getTitleLangAttribute()
    {
        return is_json($this->title) && is_object(json_decode($this->title)) ? json_decode($this->title)->{getCurrentLang()} : $this->title;
    }

    public function getTitleEnAttribute()
    {
        return is_json($this->title) && is_object(json_decode($this->title)) ? json_decode($this->title)->en : $this->title;
    }

    public function getTitleArAttribute()
    {
        return is_json($this->title) && is_object(json_decode($this->title)) ? json_decode($this->title)->ar : $this->title;
    }
}
