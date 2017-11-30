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
        return view('website.home');
    }

    public function getPageBySlug($slug){
        $page = Page::where('slug' , $slug)->first();
        if($page){
            return view('website.page' , compact('page'));
        }
        return redirect('404');
    }

    public function welcome(){
        return view('website.welcome');
    }
}
