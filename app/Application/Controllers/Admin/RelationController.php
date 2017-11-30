<?php

namespace App\Application\Controllers\Admin;

use App\Application\Controllers\AbstractController;
use Alert;
use App\Application\Model\Relation;
use App\Application\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RelationController extends AbstractController
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function index(){
        $models = getModels();
        $relations = Relation::get();
        return view('admin.relation.index' , compact('models' , 'relations'));
    }

    public function exe(Request $request){
        if(($request->primary_key && $request->foreign_key) && ($request->primary_key != $request->foreign_key)){
            if($request->col1 && $request->col2){
                $command  = $this->generateCommand($request);
                $this->artisanCall($request->primary_key , $command);
                alert()->success(trans('admin.Done'));
                return redirect()->back()->withInput();
            }
        alert()->error(trans('admin.You must select 2 cols Only'));
        return redirect()->back()->withInput();
        }
        alert()->error(trans('admin.Error'));
        return redirect()->back()->withInput();
    }

    protected function generateCommand($request){
        $ef = $request->enable_foreign == 0 ? 'false' : 'true';
        $out =  $request->primary_key.','.$request->foreign_key.','.$request->relation_type.','.$ef.','.$request->col1.','.$request->col2;
        if($request->has('fkey')){
            $out .= ','.$request->fkey;
        }
        if($request->has('typeMtm')){
            $out .= ','.$request->typeMtm;
        }
        $array = [
            'name' => $request->primary_key.'_'.$request->foreign_key,
            'command' => 'laraflat:relation',
            'options' => $out,
            'p' => $request->primary_key,
            'f' => $request->foreign_key,
            't' => $request->relation_type
        ];
        Relation::create($array);
        return $out;
    }

    public function rollback(Request $request){
        Artisan::call('laraflat:relation_rollback' , ['name' => $request->name , '--options' => $request->command]);
        alert()->success(trans('admin.Done'));
        return redirect()->back()->withInput();
    }

    protected function artisanCall($name , $options = null){
         Artisan::call('laraflat:relation' , ['name' => $name , '--options' => $options]);
        return true;
    }

    public function getCols($model){
        $model = "App\\Application\\Model\\".ucfirst($model);
        if(class_exists($model)){
            $model = new $model;
            return $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
        }
        alert()->error(trans('admin.Error'));
        return redirect()->back()->withInput();
    }

}
