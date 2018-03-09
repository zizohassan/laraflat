<?php

namespace App\Application\Controllers\Admin;

use App\Application\Controllers\AbstractController;
use App\Application\DataTables\MenusDataTable;
use App\Application\Model\Item;
use App\Application\Model\Menu;
use App\Application\Repository\InterFaces\MenuInterface;
use App\Application\Requests\Admin\Menu\AddRequestMenu;
use App\Application\Requests\Admin\Menu\UpdateRequestMenu;
use UxWeb\SweetAlert\SweetAlert;
use Yajra\Datatables\Request;
use Alert;

class MenuController extends AbstractController
{
    protected  $menuInterface;
    public function __construct(Menu $model , MenuInterface $menuInterface)
    {
        parent::__construct($model);
        $this->menuInterface = $menuInterface;
    }

    public function index(MenusDataTable $dataTable){
        return $dataTable->render('admin.menu.index');
    }

    public function show($id = null){
        $items = $this->menuInterface->getMenuById($id);
        return $this->createOrEdit('admin.menu.edit' , $id  , ['items' => $items]);
    }

    public function store(AddRequestMenu $request){
         return $this->storeOrUpdate($request , null , 'admin/menu');
    }


    public function update($id , UpdateRequestMenu $request){
        return $this->storeOrUpdate($request , $id , 'admin/menu');
    }

    public function getById($id){
        $fields = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());
        return $this->createOrEdit('admin.menu.show' , $id , ['fields' =>  $fields]);
    }

    public function destroy($id){
        return $this->deleteItem($id , 'admin/menu')->with('sucess' , 'Done Delete menu From system');
    }

    public function menuItem(\Illuminate\Http\Request $request){
        return $this->menuInterface->updateMenuItems($request);
    }

    public function addNewItemToMenu(\Illuminate\Http\Request $request){
        return $this->menuInterface->addNewItemToMenu($request);
    }

    public function getItemInfo($id){
        return $this->menuInterface->getItemById($id);
    }

    public function updateOneMenuItem(\Illuminate\Http\Request $request){
        return $this->menuInterface->updateOneMenuItem($request);
    }

    public function pluck(\Illuminate\Http\Request $request){
        return $this->deleteItem($request->id , 'admin/menu')->with('sucess' , 'Done Delete menu From system');
    }



    public function deleteMenuItem($id){
        if(Item::find($id)->delete()){
            Item::where('parent_id' ,$id)->delete();
            SweetAlert::success('Done Delete This Item' ,'Done' );
        }else{
            SweetAlert::error('Done some thing wrong' , 'Error');
        }
        return redirect()->back();
    }
}
