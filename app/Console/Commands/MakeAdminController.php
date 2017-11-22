<?php

namespace App\Console\Commands;


use App\Application\Model\Group;
use App\Application\Model\Item;
use App\Application\Model\Permission;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\File;

class MakeAdminController extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:admin_controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create Admin Controller in application path';

    protected $cols = [];

    public function handle(){
        $this->createController();
        if ($this->option('cols')) {
            $cols = $this->option('cols');
            $cols = explode(',', $cols);
            if ($cols) {
                foreach ($cols as $col) {
                    $col = explode(':', $col);
                    foreach ($col as $key => $c) {
                        if ($key == 0) {
                            $value = $c;
                        } elseif ($key == 1) {
                            $this->cols[$value][] = $c;
                        }elseif ($key == 2) {
                            $this->cols[$value][] = $c;
                        }elseif($key == 3){
                            $this->cols[$value][] = $c;
                        }
                    }
                }
            }
        }
        if(count($this->cols) > 0 ){
            $this->call('laraflat:admin_request' , ['name' => class_basename($this->getNameInput()) , '--cols' => $this->fillValidation()]);
            $this->call('laraflat:datatable', ['name' => class_basename($this->getNameInput()), '--cols' => $this->option('cols')]);
            if(!file_exists(app_path('Application/Model/'.ucfirst($this->getNameInput())).'.php')) {
                $this->call('laraflat:model', ['name' => class_basename($this->getNameInput()), '--cols' => $this->option('cols')]);
            }
        }else{
            $this->call('laraflat:admin_request' , ['name' => class_basename($this->getNameInput())]);
            $this->call('laraflat:datatable', ['name' => class_basename($this->getNameInput())]);
            if(!file_exists(app_path('Application/Model/'.ucfirst($this->getNameInput())).'.php')) {
                $this->call('laraflat:model', ['name' => class_basename($this->getNameInput())]);
            }
        }
        $this->createViews();
        $this->ImportMenuTable();
        $this->appendRoutes();
        $this->addPermissionToAdmin();
    }


    protected function createController()
    {
        $name = $this->qualifyClass(strtolower($this->getNameInput()));
        $controllerName = $this->getNameInput().'Controller';
        $dataTableName = $this->getNameInput().'sDataTable';
        $modelName= $this->getNameInput();
        $viewName = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\Controllers\\Admin\\'.$this->getNameInput().'Controller');
        $this->line('Done create Controller  at Application controller admin '.$this->getNameInput() .'Controller .');
        $this->files->put($path, $this->buildClassController( $name , $controllerName , $dataTableName , $modelName , $viewName, __DIR__.'/stub/controller.stub'));

    }

    protected function getStub()
    {
        return  __DIR__.'/stub/admincontroller.stub';
    }


    protected function buildClassController($name ,$controllerName ,  $dataTableName , $modelName , $viewName, $stub){
        $stub = $this->files->get($stub);
        return $this->replace( $stub, 'DummyModel',$modelName)
            ->replace( $stub,'DummyDataTable' ,  $dataTableName)
            ->replace( $stub,'DummyView' ,  $viewName)
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $controllerName);
    }

    protected function createViews()
    {
        $path = app_path() . '/Application/views/admin/' . strtolower($this->getNameInput());
        $pathButton = app_path() . '/Application/views/admin/' . strtolower($this->getNameInput()) . '/buttons';
        if (!file_exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        if (!file_exists($pathButton)) {
            File::makeDirectory($pathButton, $mode = 0777, true, true);
        }
        $this->CreateOnView('index');
        $this->CreateOnView('edit');
        $this->CreateOnView('show');
        $this->CreateButton('edit');
        $this->CreateButton('delete');
        $this->CreateButton('view');
        $this->CreateButton('langcol');
    }

    protected function CreateOnView($view)
    {
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\views\\admin\\' . strtolower($this->getNameInput()) . '\\' . $view . '.blade');
        $this->line('Done create view at Application view admin .');
        if ($view == 'index') {
            $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/adminViews/' . $view . '.stub'));
        } elseif ($view == 'edit') {
            $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/adminViews/' . $view . '.stub', $this->renderForm($name)));
        } elseif ($view == 'show') {
            $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/adminViews/' . $view . '.stub', $this->renderShow($name)));
        }
    }

    protected function CreateButton($view)
    {
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\views\\admin\\' . strtolower($this->getNameInput()) . '\\buttons\\' . $view . '.blade');
        $this->line('Done create action button view at Application view admin ' . $this->getNameInput() . ' button');
        $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/adminViews/buttons/' . $view . '.stub'));
    }

    protected function buildView($name, $stub, $table = null)
    {
        $stub = $this->files->get($stub);
        if ($table == null) {
            return $this->replaceView($stub, 'DummyView', $name);
        } else {
            return $this->replace($stub, 'DummyTable', $table)
                ->replaceView($stub, 'DummyView', $name);
        }
    }

    protected function renderForm($name)
    {
        $out = ' ';
        if (count($this->cols) > 0) {
            foreach ($this->cols as $key => $value) {
                $isMultiLang = isset($value[2]) && $value[2] == 'true' ? true : false;
                $out .= "\t\t".'<div class="form-group">'."\n";
                $out .= "\t\t\t".'<label for="' . $key . '">{{ trans("'.strtolower($this->getNameInput()).'.' . $key . '")}}</label>'."\n";
                if(in_array($key , getFileFieldsName())) {
                    $out .= "\t\t\t\t" . '@if(isset($item) && $item->' . $key . ' != "")' . "\n";
                    $out .= "\t\t\t\t" . '<br>' . "\n";
                    $out .= "\t\t\t\t" . '<img src="{{ url(env("UPLOAD_PATH")."/".$item->' . $key . ') }}" class="thumbnail" alt="" width="200">' . "\n";
                    $out .= "\t\t\t\t" . '<br>' . "\n";
                    $out .= "\t\t\t\t" . "@endif" . "\n";
                    $out .= "\t\t\t\t" . '<input type="file" name="' . $key . '" >' . "\n";
                }elseif($key == 'youtube'){
                        $out .= "\t\t\t\t".'@if(isset($item) && $item->'.$key.' != "")'."\n";
                        $out .= "\t\t\t\t".'<br>'."\n";
                        $out .= "\t\t\t\t".'<iframe width="420" height="315" src="https://www.youtube.com/embed/{{ isset($item->'.$key.') ? getYouTubeId($item->'.$key.') : old("'.$key.'")  }}"></iframe>'."\n";
                        $out .= "\t\t\t\t".'<br>'."\n";
                        $out .= "\t\t\t\t"."@endif"."\n";
                        $out .= "\t\t\t\t".'<input type="text" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'")  }}"  placeholder="{{ trans("'.strtolower($this->getNameInput()).'.' . $key . '")}}">'."\n";
                }else{
                    if ($value[0] == 'string' && $isMultiLang) {
                        $out .= "\t\t\t\t".'{!! extractFiled("'.$key.'" , isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'") , "text" , "'.strtolower($this->getNameInput()).'") !!}'."\n";
                    } elseif ($value[0]  == 'email' && $isMultiLang) {
                        $out .= "\t\t\t\t".'{!! extractFiled("'.$key.'" , isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'") , "email" , "'.strtolower($this->getNameInput()).'") !!}'."\n";
                    } elseif ($value[0]  == 'date' && $isMultiLang) {
                        $out .= "\t\t\t\t".'{!! extractFiled("'.$key.'" , isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'") , "date" , "'.strtolower($this->getNameInput()).'") !!}'."\n";
                    } elseif ($value[0]  == 'text' && $isMultiLang) {
                        $out .= "\t\t\t\t".'{!! extractFiled("'.$key.'" , isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'") , "textarea" , "'.strtolower($this->getNameInput()).'") !!}'."\n";
                    } elseif ($value[0]  == 'boolean') {
                        $out .= "\t\t\t\t".'<div class="form-check">'."\n";
                        $out .= "\t\t\t\t\t".'<label class="form-check-label">'."\n";
                        $out .= "\t\t\t\t\t".'<input class="form-check-input" name="' . $key . '" {{ isset($item->' . $key . ') && $item->' . $key . '  == 0 ? "checked" : "" }} type="radio" value="0">'."\n";
                        $out .= "\t\t\t\t\t".'{{ trans("'.strtolower($this->getNameInput()).'.No")}}'."\n";
                        $out .= "\t\t\t\t".'</label>'."\n";
                        $out .= "\t\t\t\t".'</div>';
                        $out .= "\t\t\t\t".'<div class="form-check">'."\n";
                        $out .= "\t\t\t\t".'<label class="form-check-label">'."\n";
                        $out .= "\t\t\t\t".'<input class="form-check-input" name="' . $key . '" {{ isset($item->' . $key . ') && $item->' . $key . '  == 1 ? "checked" : "" }} type="radio" value="1" >'."\n\t\t\t\t";
                        $out .= "\t\t\t\t\t".'{{ trans("'.strtolower($this->getNameInput()).'.Yes")}}'."\n";
                        $out .= "\t\t\t\t".'</label>'."\n";
                        $out .= "\t\t\t\t".'</div>';
                    }else{
                        if ($value[0]  == 'string') {
                            $out .= "\t\t\t\t".'<input type="text" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'")  }}"  placeholder="{{ trans("'.strtolower($this->getNameInput()).'.' . $key . '")}}">'."\n";
                        } elseif ($value[0] ==  'email') {
                            $out .= "\t\t\t\t".'<input type="email" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'") }}"  placeholder="{{ trans("'.strtolower($this->getNameInput()).'.' . $key . '")}}">'."\n";
                        } elseif ($value[0]  == 'date') {
                            $out .= "\t\t\t\t".'<input type="date" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'")  }}"  placeholder="{{ trans("'.strtolower($this->getNameInput()).'.' . $key . '")}}">'."\n";
                        } elseif ($value[0]  == 'text') {
                            $out .= "\t\t\t\t".'<textarea name="' . $key . '" class="form-control" id="' . $key . '"   placeholder="{{ trans("'.strtolower($this->getNameInput()).'.' . $key . '")}}">{{ isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'")  }}</textarea>'."\n";
                        }else{
                            $out .= "\t\t\t\t".'<input type="text" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'")  }}"  placeholder="{{ trans("'.strtolower($this->getNameInput()).'.' . $key . '")}}">'."\n";
                        }
                    }
                }
                $out .= "\t\t\t".'</label>'."\n";
                $out .= "\t\t".'</div>'."\n";
            }
        }
        return $out;
    }

    protected function renderShow($name){
        $out = '';
        if (count($this->cols) > 0) {
            $out .= "\t\t".'<table class="table table-bordered table-responsive table-striped">'."\n";
            $out .= "\t\t\t".'</tr>'."\n";
            foreach ($this->cols as $key => $value) {
                $isMultiLang = isset($value[2]) && $value[2] == 'true' ? true : false;
                $out .=  "\t\t\t\t".'<tr><th>{{ trans("'.strtolower($this->getNameInput()).'.' . $key . '") }}</th>'."\n";
                $out .=  "\t\t\t\t".'@php $type =  getFileType("'.$key.'" , $item->'.$key.') @endphp'."\n";
                $out .= "\t\t\t\t".'@if($type == "File")'."\n";
                $out .= "\t\t\t\t\t".'<td> <a href="{{ url(env("UPLOAD_PATH")."/".$item->'.$key.') }}">{{ $item->'.$key.' }}</a></td>'."\n";
                $out .= "\t\t\t\t".'@elseif($type == "Image")'."\n";
                $out .= "\t\t\t\t\t".'<td> <img src="{{ url(env("UPLOAD_PATH")."/".$item->'.$key.') }}" /></td>'."\n";
                $out .= "\t\t\t\t".'@else'."\n";
                if($key == 'youtube'){
                    $out .= "\t\t\t\t".'@if(isset($item) && $item->'.$key.' != "")'."\n";
                    $out .= "\t\t\t\t\t".'<td>'."\n";
                    $out .= "\t\t\t\t".'<iframe width="420" height="315" src="https://www.youtube.com/embed/{{ isset($item->'.$key.') ? getYouTubeId($item->'.$key.') : old("'.$key.'")  }}"></iframe>'."\n";
                    $out .= "\t\t\t\t\t".'</td>'."\n";
                    $out .= "\t\t\t\t"."@endif"."\n";
                }else if($value[0] == 'boolean'){
                    $out .= "\t\t\t\t\t".'<td>'."\n";
                    $out .= "\t\t\t\t".'{{ $item->'.$key.' == 1 ? trans("'.strtolower($this->getNameInput()).'.Yes") : trans("'.strtolower($this->getNameInput()).'.No")  }}'."\n";
                    $out .= "\t\t\t\t\t".'</td>'."\n";
                }else{
                    if($isMultiLang){
                        $out .=  "\t\t\t\t\t".'<td>{{ getDefaultValueKey(nl2br($item->'.$key.')) }}</td>'."\n";
                    }else{
                        $out .=  "\t\t\t\t\t".'<td>{{ nl2br($item->'.$key.') }}</td>'."\n";
                    }
                }
                $out .= "\t\t\t\t".'@endif</tr>'."\n";
            }
            $out .= "\t\t\t".'</tr>'."\n";
            $out .= "\t\t".'</table>'."\n";
        }else{
            $out .= "\t\t".'<table class="table table-bordered table-responsive table-striped">'."\n";
            $out .= "\t\t".'@php'."\n";
            $out .= "\t\t".'$fields = rename_keys('."\n";
            $out .= "\t\t".'removeFromArray($item["fields"] , ["updated_at"]) ,'."\n";
            $out .= "\t\t".'["UserName"]'."\n";
            $out .= "\t\t".');'."\n";
            $out .= "\t\t".'@endphp'."\n";
            $out .= "\t\t".'@foreach($fields as $key =>  $field)'."\n";
            $out .= "\t\t\t".'<tr>'."\n";
            $out .= "\t\t\t\t".'<th>{{ $key }}</th>'."\n";
            $out .= "\t\t\t\t".'@php $type =  getFileType($field , $item[$field]) @endphp'."\n";
            $out .= "\t\t\t\t".'@if($type == "File")'."\n";
            $out .= "\t\t\t\t\t".'<td> <a href="{{ url(env("UPLOAD_PATH")."/".$item[$field]) }}">{{ $item[$field] }}</a></td>'."\n";
            $out .= "\t\t\t\t".'@elseif($type == "Image")'."\n";
            $out .= "\t\t\t\t\t".'<td> <img src="{{ url(env("UPLOAD_PATH")."/".$item[$field]) }}" /></td>'."\n";
            $out .= "\t\t\t\t".'@else'."\n";
            $out .= "\t\t\t\t\t".' <td>{!!  getDefaultValueKey(nl2br($item[$field]))  !!}</td>'."\n";
            $out .= "\t\t\t\t".'@endif'."\n";
            $out .= "\t\t\t".'</tr>'."\n";
            $out .= "\t\t".'@endforeach'."\n";
            $out .= "\t\t".'</table>'."\n";
        }
        return $out;

    }


    protected function replace(&$stub, $rep, $name)
    {
        $stub = str_replace(
            [$rep],
            $name,
            $stub
        );
        return $this;
    }

    protected function replaceView(&$stub, $rep, $name)
    {
        $stub = str_replace(
            [$rep],
            $name,
            $stub
        );
        return $stub;
    }

    protected function getOptions()
    {
        return [
            ['cols', 'c', InputArgument::OPTIONAL, 'Set Model Fillable , request , migration columns']
        ];
    }

    protected function fillValidation(){
        $result = '';
        $i = 0;
        foreach($this->cols as $key => $value){
            $i++;
            $isMultiLang = isset($value[2]) && $value[2] == 'true' ? '.*' : '';
            $result .= $key.$isMultiLang.':'.str_replace('|' , '_' ,str_replace(':' , '-' , $value[1]));
            $result .=count($this->cols)  != $i ? ',':'';
        }
        return $result;
    }

    protected function ImportMenuTable()
    {
        $name = $this->getNameInput();
        $this->insertItem($name, 1, '/admin/' . strtolower($name));
        $this->insertItem($name, 3, strtolower($name), '<i class="fa fa-plus-square-o" aria-hidden="true"></i> ');
        $this->line('Done Add Item to menu table  .');
    }

    protected function insertItem($name, $menu_id, $link, $icon = '<i class="material-icons">control_point</i>')
    {
        $order = Item::count();
        $menu = new Item();
        $menu->name = encodeJson(['en' => $name, 'ar' => $name]);
        $menu->link = $link;
        $menu->parent_id = 0;
        $menu->menu_id = $menu_id;
        $menu->order = $order + 1;
        $menu->type = '';
        $menu->icon = $icon;
        $menu->save();
    }

    protected function addPermissionToAdmin()
    {
        $name = $this->getNameInput();
        $methods = ['index' , 'show' , 'store' , 'update' , 'getById' , 'destroy'];
        $id = [];
        foreach($methods as $method){
            $array = [
                'name' => $method."-".$name."Controller",
                'slug' => "App-Application-Admin-".$name."-Controller".'-'.$method,
                'description' => "Allow admin on ". $method." in controller ". $name ." Controller",
                'controller_name' => $name.'Controller',
                'method_name' => $method,
                'controller_type' => 'admin',
                'namespace' => "App\\Application\\Controllers\\Admin\\".$name."Controller",
                'permission' => 1
            ];
           $item =  \App\Application\Model\Permission::create($array);
            $id[] = $item->id;
        }
        $group = Group::find(1);
        $group->permission()->attach($id);
    }

    protected function appendRoutes()
    {
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\routes\\admin');
        $this->line('Done append routes to route file at Application route  admin .');
        $this->files->append($path, $this->buildRoute($name, __DIR__ . '/stub/routes.stub'));
    }

    protected function buildRoute($name, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DummyRoute', $name)
            ->replaceView($stub, 'DummyView', ucfirst($name));
    }


}
