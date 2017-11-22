<?php

namespace App\Console\Commands;


use App\Application\Model\Group;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\File;

class MakeController extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create  Controller in application path';


    protected $cols = [];

    public function handle()
    {
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
                        }elseif ($key == 3) {
                            $this->cols[$value][] = $c;
                        }
                    }
                }
            }
            if(!file_exists(app_path('Application/Model/'.ucfirst($this->getNameInput())).'.php')) {
                $this->call('laraflat:model', ['name' => class_basename($this->getNameInput()), '--cols' => $this->option('cols')]);
            }
        } else {
            if(!file_exists(app_path('Application/Model/'.ucfirst($this->getNameInput())).'.php')) {
                $this->call('laraflat:model', ['name' => class_basename($this->getNameInput())]);
            }
        }
        $this->createController();
        $this->route();
        $this->createViews();
        $this->addPermission();
        $this->addUserPermission();
    }

    protected function addUserPermission()
    {
        $name = $this->getNameInput();
        $methods = ['index' , 'show' , 'store' , 'update' , 'getById' , 'destroy'];
        $id = [];
        foreach($methods as $method){
            $array = [
                'name' => 'users-website'.$method."-".$name."Controller",
                'slug' => "App-Application-Admin-".$name."-Controller".'-'.$method,
                'description' => "Allow admin on ". $method." in controller ". $name ." Controller",
                'controller_name' => $name.'Controller',
                'method_name' => $method,
                'controller_type' => 'website',
                'namespace' => "App\\Application\\Controllers\\Website\\".$name."Controller",
                'permission' => 1
            ];
            $item =  \App\Application\Model\Permission::create($array);
            $id[] = $item->id;
        }
        $group = Group::find(2);
        $group->permission()->attach($id);
    }

    protected function addPermission()
    {
        $name = $this->getNameInput();
        $methods = ['index' , 'show' , 'store' , 'update' , 'getById' , 'destroy'];
        $id = [];
        foreach($methods as $method){
            $array = [
                'name' => 'admin-website-'.$method."-".$name."Controller",
                'slug' => "App-Application-Admin-".$name."-Controller".'-'.$method,
                'description' => "Allow admin on ". $method." in controller ". $name ." Controller",
                'controller_name' => $name.'Controller',
                'method_name' => $method,
                'controller_type' => 'website',
                'namespace' => "App\\Application\\Controllers\\Website\\".$name."Controller",
                'permission' => 1
            ];
            $item =  \App\Application\Model\Permission::create($array);
            $id[] = $item->id;
        }
        $group = Group::find(1);
        $group->permission()->attach($id);
    }

    protected function createController()
    {
        $name = $this->qualifyClass(strtolower($this->getNameInput()));
        $controllerName = $this->getNameInput();
        $modelName = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\Controllers\\Website\\' . $this->getNameInput() . 'Controller');
        $this->line('Done create Controller at Application controller website ' . $this->getNameInput() . 'Controller .');
        $this->files->put($path, $this->buildClassController($name, $controllerName, $this->getStub(), $modelName));

    }

    protected function getStub()
    {
        return __DIR__ . '/stub/usercontroller.stub';
    }


    protected function buildClassController($name, $controllerName, $stub, $modelName)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DummyView', $modelName)
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $controllerName);
    }

    protected function getOptions()
    {
        return [
            ['cols', 'c', InputArgument::OPTIONAL, 'Set Model Fillable , request , migration columns']
        ];
    }

    protected function route()
    {
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\routes\\appendWebsite');
        $this->line('Done append routes to route file at Application route  .');
        $this->files->append($path, $this->websiteRoute($name, __DIR__ . '/stub/routeWebsite.stub'));
    }

    protected function websiteRoute($name, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DummyRoute', $name)
            ->replaceView($stub, 'Dummy', ucfirst($name));
    }

    protected function createViews()
    {
        $path = app_path() . '/Application/views/website/' . strtolower($this->getNameInput());
        $pathButton = app_path() . '/Application/views/website/' . strtolower($this->getNameInput()) . '/buttons';
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
    }

    protected function CreateOnView($view)
    {
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\views\\website\\' . strtolower($this->getNameInput()) . '\\' . $view . '.blade');
        $this->line('Done create view at Application view website .');
        if ($view == 'index') {
            $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/views/' . $view . '.stub', $this->renderTable($name)));
        } elseif ($view == 'edit') {
            $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/views/' . $view . '.stub', $this->renderForm($name)));
        } elseif ($view == 'show') {
            $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/views/' . $view . '.stub', $this->renderShow($name)));
        }
    }

    protected function CreateButton($view)
    {
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\views\\website\\' . strtolower($this->getNameInput()) . '\\buttons\\' . $view . '.blade');
        $this->line('Done create action button view at Application view website ' . $this->getNameInput() . ' button');
        $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/views/buttons/' . $view . '.stub'));
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
                if(in_array($key , getFileFieldsName())){
                    $out .= "\t\t\t\t".'@if(isset($item) && $item->'.$key.' != "")'."\n";
                    $out .= "\t\t\t\t".'<br>'."\n";
                    $out .= "\t\t\t\t".'<img src="{{ url(env("UPLOAD_PATH")."/".$item->'.$key.') }}" class="thumbnail" alt="" width="200">'."\n";
                    $out .= "\t\t\t\t".'<br>'."\n";
                    $out .= "\t\t\t\t"."@endif"."\n";
                    $out .= "\t\t\t\t".'<input type="file" name="'.$key.'" >'."\n";
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
                        $out .= "\t\t\t\t".'<input class="form-check-input" name="' . $key . '" {{ isset($item->' . $key . ') && $item->' . $key . ' == 1 ? "checked" : "" }} type="radio" value="1" >'."\n\t\t\t\t";
                        $out .= "\t\t\t\t\t".'{{ trans("'.strtolower($this->getNameInput()).'.Yes")}}'."\n";
                        $out .= "\t\t\t\t".'</label>'."\n";
                        $out .= "\t\t\t\t".'</div>';
                    }else{
                        if ($value[0]  == 'string') {
                            $out .= "\t\t\t\t".'<input type="text" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'") }}"  placeholder="{{ trans("'.strtolower($this->getNameInput()).'.' . $key . '")}}">'."\n";
                        } elseif ($value[0] ==  'email') {
                            $out .= "\t\t\t\t".'<input type="email" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'") }}"  placeholder="{{ trans("'.strtolower($this->getNameInput()).'.' . $key . '")}}">'."\n";
                        } elseif ($value[0]  == 'date') {
                            $out .= "\t\t\t\t".'<input type="date" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'") }}"  placeholder="{{ trans("'.strtolower($this->getNameInput()).'.' . $key . '")}}">'."\n";
                        } elseif ($value[0]  == 'text') {
                            $out .= "\t\t\t\t".'<textarea name="' . $key . '" class="form-control" id="' . $key . '"   placeholder="{{ trans("'.strtolower($this->getNameInput()).'.' . $key . '")}}">{{ isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'") }}</textarea>'."\n";
                        }else{
                            $out .= "\t\t\t\t".'<input type="text" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->'.$key.') ? $item->'.$key.' : old("'.$key.'") }}"  placeholder="{{ trans("'.strtolower($this->getNameInput()).'.' . $key . '")}}">'."\n";
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

    protected function renderTable($name)
    {
        $out = '<table class="table table-responsive table-striped table-bordered">' . "\n\t\t";
        $out .= '<thead>' . "\n\t\t\t";
        if (count($this->cols) > 0) {
            $out .= '<tr>' . "\n\t\t\t\t";
            foreach ($this->cols as $key => $value) {
                $out .= '<th>{{ trans("'.strtolower($this->getNameInput()).'.' . $key . '") }}</th>' . "\n\t\t\t\t";
            }
            $out .= '<th>{{ trans("'.strtolower($this->getNameInput()).'.edit") }}</th>' . "\n\t\t\t\t";
            $out .= '<th>{{ trans("'.strtolower($this->getNameInput()).'.show") }}</th>' . "\n\t\t\t\t";
            $out .= '<th>{{ trans("'.strtolower($this->getNameInput()).'.delete") }}</th>' . "\n\t\t\t\t";
        } else {
            $out .= '<tr><th></th></tr>' . "\n\t\t\t\t";
        }
        $out .= '</thead>' . "\n\t\t";
        $out .= '<tbody>' . "\n\t\t";
        $out .= '@if(count($items) > 0)' . "\n\t\t\t";
        $out .= '@foreach($items as $d)' . "\n\t\t\t\t";
        if (count($this->cols) > 0) {
            $out .= '<tr>'."\n\t\t\t\t\t";
            foreach ($this->cols as $key => $value) {
                $isMultiLang = isset($value[2]) && $value[2] == 'true' ? true : false;
                if($value[0] == 'boolean'){
                    $out .= "\t\t\t\t\t".'<td>'."\n";
                    $out .= "\t\t\t\t".'{{ $d->'.$key.' == 1 ? trans("'.strtolower($this->getNameInput()).'.Yes") : trans("'.strtolower($this->getNameInput()).'.No")  }}'."\n";
                    $out .= "\t\t\t\t\t".'</td>'."\n";
                }else if(in_array($key , getFileFieldsName())){
                    $out .= "\t\t\t\t\t".'<td>'."\n";
                    $out .= "\t\t\t\t".'<img src="{{ url(env("UPLOAD_PATH")."/".$d->'.$key.')}}"  width="80" />'."\n";
                    $out .= "\t\t\t\t\t".'</td>'."\n";
                }else{
                    if($isMultiLang){
                        $out .= '<td>{{ str_limit(getDefaultValueKey($d->' . $key . ') , 20) }}</td>' . "\n\t\t\t\t";
                    }else{
                        $out .= '<td>{{ str_limit($d->' . $key . ' , 20) }}</td>' . "\n\t\t\t\t";
                    }
                }
            }
            $out .= '<td>@include("website.' . $name . '.buttons.edit", ["id" => $d->id ])</td>' . "\n\t\t\t\t\t";
            $out .= '<td>@include("website.' . $name . '.buttons.view", ["id" => $d->id ])</td>' . "\n\t\t\t\t\t";
            $out .= '<td>@include("website.' . $name . '.buttons.delete", ["id" => $d->id ])</td>' . "\n\t\t\t\t\t";
            $out .= '</tr>'."\n\t\t\t\t\t";
        } else {
            $out .= '<tr><th></th></tr>' . "\n\t\t\t\t\t";
        }
        $out .= '@endforeach' . "\n\t\t\t\t";
        $out .= '@endif' . "\n\t\t\t";
        $out .= '</tbody>' . "\n\t\t";
        $out .= '</table>' . "\n\t";
        $out .= '@include("layouts.paginate" , ["items" => $items])' . "\n\t\t";
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

}
