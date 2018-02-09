<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $table = "page";

    protected $fillable = [
        'title', 'body', 'active'
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

    public function getBodyLangAttribute()
    {
        return is_json($this->body) && is_object(json_decode($this->body)) ? json_decode($this->body)->{getCurrentLang()} : $this->body;
    }

    public function getBodyEnAttribute()
    {
        return is_json($this->body) && is_object(json_decode($this->body)) ? json_decode($this->body)->en : $this->body;
    }

    public function getBodyArAttribute()
    {
        return is_json($this->body) && is_object(json_decode($this->body)) ? json_decode($this->body)->ar : $this->body;
    }
}
