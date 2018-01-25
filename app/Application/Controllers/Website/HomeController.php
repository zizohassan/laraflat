<?php

namespace App\Application\Controllers\Website;



use App\Application\Controllers\AbstractController;
use App\Application\Controllers\Controller;
use App\Application\Model\Page;
use App\Application\Model\User;


class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(layoutHomePage('website'));
    }


    public function welcome(){
        return view(layoutHomePage('website'));
    }
}
