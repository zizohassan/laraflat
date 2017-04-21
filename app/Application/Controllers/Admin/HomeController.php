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

    public function index(){
        $data = $this->homeInterface->getData();
        return view('admin.home.index' ,compact('data'));
    }

}
