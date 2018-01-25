<?php

namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $table = "page";

    protected $fillable = [
        'title', 'body', 'active'
    ];
}
