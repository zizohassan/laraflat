<?php

namespace App\Application\Repository\InterFaces;

interface HomeInterface{
    public function getData($days , $limit);
}