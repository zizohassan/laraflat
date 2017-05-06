<?php

namespace App\Application\Controllers\Admin;

use App\Application\Controllers\AbstractController;
use App\Application\DataTables\HomesDataTable;
use App\Application\Model\Home;
use App\Application\Model\User;
use App\Application\Repository\InterFaces\HomeInterface;
use Yajra\Datatables\Request;
use Alert;

class HomeController extends AbstractController
{
    protected $homeInterface;
    public function __construct(User $model , HomeInterface $homeInterface)
    {
        parent::__construct($model);
        $this->homeInterface = $homeInterface;
    }

    public function index($pages = null , $limit = null){
        $data = $this->homeInterface->getData($pages , $limit);
        return view('admin.home.index' ,compact('data'));
    }

    public function icons(){
        return view('admin.layout.static.icons');
    }

    public function apiDocs(){
        return view('vendor.apidoc.index');
    }

}
