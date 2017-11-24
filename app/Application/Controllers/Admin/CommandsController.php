<?php

namespace App\Application\Controllers\Admin;

use App\Application\Controllers\AbstractController;
use App\Application\Model\Categorie;
use Alert;
use App\Application\Model\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class CommandsController extends AbstractController
{
    public function __construct(Categorie $model)
    {
        parent::__construct($model);
    }

    public function index(){
        $commands = $this->laraFlatCommands();
        $migrationTypes = $this->migrationType();
        $validationTypes = $this->validationTypes();
        $history = Command::get();
        return view('admin.commands.index' , compact('commands' , 'migrationTypes' , 'validationTypes' , 'history'));
    }

    public function command(){
        $commands = $this->commands();
        return view('admin.commands.other' , compact('commands'));
    }

    public function otherExe(Request $request){
        if($request->commands == 'migrate'){
            $this->clearAllTables();
            Artisan::call($request->commands);
            Artisan::call("db:seed");
        }else{
            Artisan::call($request->commands);
        }
        shell_exec('composer --working-dir='.app_path("/").' dumpautoload');
        alert()->success(trans('admin.Done'));
        return redirect()->back()->withInput();
    }

    protected function clearAllTables(){
        Schema::disableForeignKeyConstraints();
        $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
        foreach ($tableNames as $name) {
            Schema::dropIfExists($name);
        }
        Schema::enableForeignKeyConstraints();
    }

    protected function commands(){
        return [
            'migrate',
            'db:seed',
            'cache:clear',
            'cache:forget',
            'route:cache',
            'route:clear',
            'storage:link',
            'view:clear'
        ];
    }

    public function exe(Request $request){
        if($request->name){
            if(in_array($request->commands , $this->commands()) &&  $request->commands != 'laraflat:admin_model'){
                $this->artisanCall($request->commands , ucfirst($request->name));
            }else{
                if(count($request->colsName) > 0){
                    $cols = $this->handelRequest($request);
                    $this->artisanCall($request->commands , ucfirst($request->name) , $cols);
                }else{
                    $this->artisanCall($request->commands , ucfirst($request->name));
                }
            }
            alert()->success(trans('admin.Done'));
            return redirect()->back()->withInput();
        }
        alert()->error(trans('admin.Error'));
        return redirect()->back()->withInput();
    }

    protected function artisanCall($command , $name , $cols = null){
        $array = [
            'name' => $name,
            'command' => $command,
            'options' => $cols
        ];
        Command::create($array);
        if($cols == null){
            return Artisan::call($command , ['name' => $name]);
        }
         Artisan::call($command , ['name' => $name , '--cols' => $cols]);
         Artisan::call("migrate");
        Artisan::call('langman:sync');
        return true;
    }


    protected function handelRequest($request){
        $colsOption = "";
        $count = 0;
        foreach($request->colsName as $key =>  $cols){
            $count++;
            $lang = $request->lang[$key] == 0 ? 'false' : 'true';
            $validation = $this->handelValidation($request->validation[$key] , $request->validationVal[$key]);
            $colsOption .= $cols.':'.$request->migration[$key].':'.$validation.':'.$lang;
            if($count != count($request->colsName)){
                $colsOption .= ',';
            }
        }
      return $colsOption;
    }

    protected function handelValidation($validation  , $vVlaue){
        $out = '';
        if(is_array($validation)){
            $count = 0;
            foreach($validation as $key => $value){
                $count++;
                if(key_exists($key , $vVlaue) && $vVlaue[$key] != null){
                    $out .= $key.'-'.$vVlaue[$key];
                    if($count != count($validation)){
                        $out .= '_';
                    }
                }else{
                    $out .= $key;
                    if($count != count($validation)){
                        $out .= '_';
                    }
                }
            }
        }
        return $out;
    }

    protected function migrationType(){
        return [
            'string',
            'boolean',
            'char',
            'date',
            'double',
            'text',
            'mediumText',
            'longText',
            'float',
            'integer',
            'ipAddress',
            'tinyInteger'
        ];
    }

    protected function validationTypes(){
        return [
            'min' => true,
            'max' => true,
            'required' => false,
            'nullable' => false,
            'email' => false,
            'date' => false,
            'boolean' => false,
            'ip' => false,
            'integer' => false,
            'image' => false,
            'url' => false,
        ];
    }

    protected function laraFlatCommands(){
        return [
            'laraflat:admin_controller',
            'laraflat:admin_model',
            'laraflat:admin_request',
            'laraflat:api_controller',
            'laraflat:api_request',
            'laraflat:controller',
            'laraflat:datatable',
            'laraflat:interface',
            'laraflat:migrate',
            'laraflat:model',
            'laraflat:request',
            'laraflat:rollback',
            'laraflat:transformer'
        ];
    }
}
