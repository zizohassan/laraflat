<?php

namespace App\Application\Repository\InterFaces;

interface UserInterface{
    public function getPermissions();
    public function checkRequest($id , $request);
    public function getPermissionById($id);
}