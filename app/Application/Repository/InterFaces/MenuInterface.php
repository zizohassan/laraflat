<?php

namespace App\Application\Repository\InterFaces;

interface MenuInterface{
    public function updateMenuItems($request);
    public function getMenuById($id);
    public function addNewItemToMenu($request);
    public function getItemById($id);
    public function  updateOneMenuItem($request);
}