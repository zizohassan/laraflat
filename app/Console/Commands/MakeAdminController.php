<?php

namespace App\Console\Commands;


use App\Application\Model\Group;
use App\Application\Model\Item;
use App\Application\Model\Permission;
use App\Console\Commands\Helpers\ControllerTrait;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\File;

class MakeAdminController extends GeneratorCommand
{
    use ControllerTrait;
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
                        } elseif ($key == 2) {
                            $this->cols[$value][] = $c;
                        } elseif ($key == 3) {
                            $this->cols[$value][] = $c;
                        }
                    }
                }
            }
        }
        $this->createController();
        if (count($this->cols) > 0) {
            $this->call('laraflat:admin_request', ['name' => class_basename($this->getNameInput()), '--cols' => $this->fillValidation()]);
            $this->call('laraflat:datatable', ['name' => class_basename($this->getNameInput()), '--cols' => $this->option('cols')]);
            if (!file_exists(app_path('Application/Model/' . ucfirst($this->getNameInput())) . '.php')) {
                $this->call('laraflat:model', ['name' => class_basename($this->getNameInput()), '--cols' => $this->option('cols')]);
            }
        } else {
            $this->call('laraflat:admin_request', ['name' => class_basename($this->getNameInput())]);
            $this->call('laraflat:datatable', ['name' => class_basename($this->getNameInput())]);
            if (!file_exists(app_path('Application/Model/' . ucfirst($this->getNameInput())) . '.php')) {
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
        $controllerName = $this->getNameInput() . 'Controller';
        $dataTableName = $this->getNameInput() . 'sDataTable';
        $modelName = $this->getNameInput();
        $viewName = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\Controllers\\Admin\\' . $this->getNameInput() . 'Controller');
        $this->line('Done create Controller  at Application controller admin ' . $this->getNameInput() . 'Controller .');
        $this->files->put($path, $this->buildClassController($name, $controllerName, $dataTableName, $modelName, $viewName, __DIR__ . '/stub/controller.stub'));

    }

    protected function getStub()
    {
        return __DIR__ . '/stub/admincontroller.stub';
    }

    protected function buildClassController($name, $controllerName, $dataTableName, $modelName, $viewName, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DummyModel', $modelName)
            ->replace($stub, 'DummyDataTable', $dataTableName)
            ->replace($stub, 'DummyView', $viewName)
            ->replace($stub , 'DummyUpdateFunction' , $this->controllerUpdateImageBeforeStore())
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
        $this->CreateButton('id');
    }

    protected function CreateOnView($view)
    {
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\views\\admin\\' . strtolower($this->getNameInput()) . '\\' . $view . '.blade');
        $this->line('Done create view at Application view admin .');
        if ($view == 'index') {
            $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/adminViews/' . $view . '.stub' , $this->buildFilterForms() , 'index'));
        } elseif ($view == 'edit') {
            $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/adminViews/' . $view . '.stub', $this->renderForm($name)));
        } elseif ($view == 'show') {
            $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/adminViews/' . $view . '.stub', $this->renderShow($name)));
        }
    }

    protected function buildFilterForms(){
        if(count($this->cols) > 0){
            $name = strtolower($this->getNameInput());
            $out = '';
            foreach ($this->cols as $key => $filter) {
                if(!in_array($key ,notFilter() )){
                    if($filter[0] != 'boolean'){
                        if($key == 'date' || $filter[0] =='date'){
                            $type = 'text';
                            $class = 'datepicker2';
                        }else if($key == 'url'){
                            $type = 'url';
                            $class = '';
                        }else if($key == 'youtube'){
                            $type = 'url';
                            $class = '';
                        }else if ($key == 'time') {
                            $type = 'text';
                            $class = 'time';
                        }elseif( str_contains($key , '[]')){
                            $key = str_replace('[]' , '' , $key);
                            $type = 'text';
                            $class = '';
                        }else{
                            $type = 'text';
                            $class = '';
                        }
                        $out .="\t\t".'<div class="form-group">'."\n";
                        $out .="\t\t\t".'<input type="'.$type.'" name="';
                        $out .= $key;
                        $out.='" class="form-control '.$class.'" placeholder="';
                        $out .='{{ trans("'.$name.'.'.$key.'") }}';
                        $out .= '" value="';
                        $out .='{{ request()->has("'.$key.'") ? request()->get("'.$key.'") : "" }}';
                        $out .='">'."\n";
                        $out .="\t\t".'</div>'."\n";
                    }else{
                        $out .="\t\t".'<div class="form-group">'."\n";
                        $out .="\t\t\t".'<select style="width:80px" name="';
                        $out .= $key;
                        $out.='" class="form-control select2" placeholder="';
                        $out .='{{ trans("'.$name.'.'.$key.'") }}">'."\n";
                        $out .= "\t\t\t\t".'<option value="1"';
                        $out .='{{ request()->has("'.$key.'") &&  request()->get("'.$key.'") === 1 ? "selected" : "" }}';
                        $out .= '>';
                        $out .='{{ trans("'.$name.'.Yes") }}';
                        $out .= '</option>'."\n";
                        $out .= "\t\t\t\t".'<option value="0"';
                        $out .='{{ request()->has("'.$key.'") &&  request()->get("'.$key.'") === 0 ? "selected" : "" }}';
                        $out .= '>';
                        $out .='{{ trans("'.$name.'.No") }}';
                        $out .= '</option>'."\n";
                        $out .="\t\t".'</select>'."\n";
                        $out .= "\t\t".'</div>'."\n";
                    }
                }
            }
            return $out;
        }
    }

    protected function CreateButton($view)
    {
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\views\\admin\\' . strtolower($this->getNameInput()) . '\\buttons\\' . $view . '.blade');
        $this->line('Done create action button view at Application view admin ' . $this->getNameInput() . ' button');
        $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/adminViews/buttons/' . $view . '.stub'));
    }

    protected function buildView($name, $stub, $table = null , $viewAame = null)
    {
        $stub = $this->files->get($stub);
        if($viewAame == null){
            if ($table == null) {
                return $this->replaceView($stub, 'DummyView', $name);
            } else {
                return $this->replace($stub, 'DummyTable', $table)
                    ->replaceView($stub, 'DummyView', $name);
            }
        }else{
            return $this->replace($stub, 'DummyFilterFields', $table)
                ->replaceView($stub, 'DummyView', $name);
        }

    }

//    protected function renderForm($name)
//    {
//        $out = ' ';
//        if (count($this->cols) > 0) {
//            foreach ($this->cols as $key => $value) {
//                $isMultiLang = isset($value[2]) && $value[2] == 'true' ? true : false;
//                $out .= "\t\t" . '<div class="form-group">' . "\n";
//                $k = str_contains( $key , '[]') ? str_replace('[]' ,'', $key) : $key;
//                $out .= "\t\t\t" . '<label for="' . $k . '">{{ trans("' . strtolower($this->getNameInput()) . '.' . $k . '")}}</label>' . "\n";
//                if (in_array($key, getFileFieldsName())) {
//                    if(str_contains($key , '[]')){
//                        $out .= $this->inputAsArray($key , 'file');
//                    }else{
//                        $out .= "\t\t\t\t" . '@if(isset($item) && $item->' . $key . ' != "")' . "\n";
//                        $out .= "\t\t\t\t" . '<br>' . "\n";
//                        $out .= "\t\t\t\t" . '<img src="{{ url(env("SMALL_IMAGE_PATH")."/".$item->' . $key . ') }}" class="thumbnail" alt="" width="200">' . "\n";
//                        $out .= "\t\t\t\t" . '<br>' . "\n";
//                        $out .= "\t\t\t\t" . "@endif" . "\n";
//                        $out .= "\t\t\t\t" . '<input type="file" name="' . $key . '" >' . "\n";
//                    }
//                } elseif ($key == 'youtube') {
//                    $out .= "\t\t\t\t" . '@if(isset($item) && $item->' . $key . ' != "")' . "\n";
//                    $out .= "\t\t\t\t" . '<br>' . "\n";
//                    $out .= "\t\t\t\t" . '<iframe width="420" height="315" src="https://www.youtube.com/embed/{{ isset($item->' . $key . ') ? getYouTubeId($item->' . $key . ') : old("' . $key . '")  }}"></iframe>' . "\n";
//                    $out .= "\t\t\t\t" . '<br>' . "\n";
//                    $out .= "\t\t\t\t" . "@endif" . "\n";
//                    $out .= "\t\t\t\t" . '<input type="url" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '")  }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
//                } elseif ($key == 'icon') {
//                    $out .= "\t\t\t\t" . '<input type="text" name="' . $key . '" class="form-control icon-field" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
//                } elseif ($key == 'url') {
//                    $out .= "\t\t\t\t" . '<input type="url" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
//                } elseif ($key == 'date') {
//                    $out .= "\t\t\t\t" . '<input type="text" name="' . $key . '" class="form-control datepicker" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
//                } elseif ($key == 'time') {
//                    $out .= "\t\t\t\t" . ' <input type="text" name="' . $key . '" class="form-control time" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
//                }elseif ($key == 'lat') {
//                    $out .= "\t\t\t\t" . ' <input type="text" name="' . $key . '" class="form-control lat" style="display:none" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
//                    $out .= $this->map();
//                }elseif ($key == 'lng') {
//                    $out .= "\t\t\t\t" . ' <input type="text" name="' . $key . '" class="form-control lng" style="display:none" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
//                }elseif (str_contains($key , '[]')) {
//                    $out .= $this->inputAsArray($key);
//                } else {
//                    if ($value[0] == 'string' && $isMultiLang) {
//                        $out .= "\t\t\t\t" . '{!! extractFiled(isset($item) ? $item : null , "' . $key . '" , isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") , "text" , "' . strtolower($this->getNameInput()) . '") !!}' . "\n";
//                    } elseif ($value[0] == 'email' && $isMultiLang) {
//                        $out .= "\t\t\t\t" . '{!! extractFiled(isset($item) ? $item : null , "' . $key . '" , isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") , "email" , "' . strtolower($this->getNameInput()) . '") !!}' . "\n";
//                    } elseif ($value[0] == 'date' && $isMultiLang) {
//                        $out .= "\t\t\t\t" . '{!! extractFiled(isset($item) ? $item : null , "' . $key . '" , isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") , "date" , "' . strtolower($this->getNameInput()) . '" , "datepicker") !!}' . "\n";
//                    } elseif ($value[0] == 'text' && $isMultiLang) {
//                        $out .= "\t\t\t\t" . '{!! extractFiled(isset($item) ? $item : null , "' . $key . '" , isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") , "textarea" , "' . strtolower($this->getNameInput()) . '") !!}' . "\n";
//                    } elseif ($value[0] == 'boolean') {
//                        $out .= "\t\t\t\t" . '<div class="form-check">' . "\n";
//                        $out .= "\t\t\t\t\t" . '<label class="form-check-label">' . "\n";
//                        $out .= "\t\t\t\t\t" . '<input class="form-check-input" name="' . $key . '" {{ isset($item->' . $key . ') && $item->' . $key . '  == 0 ? "checked" : "" }} type="radio" value="0">' . "\n";
//                        $out .= "\t\t\t\t\t" . '{{ trans("' . strtolower($this->getNameInput()) . '.No")}}' . "\n";
//                        $out .= "\t\t\t\t" . '</label>' . "\n";
//                        $out .= "\t\t\t\t" . '<label class="form-check-label">' . "\n";
//                        $out .= "\t\t\t\t" . '<input class="form-check-input" name="' . $key . '" {{ isset($item->' . $key . ') && $item->' . $key . '  == 1 ? "checked" : "" }} type="radio" value="1" >' . "\n\t\t\t\t";
//                        $out .= "\t\t\t\t\t" . '{{ trans("' . strtolower($this->getNameInput()) . '.Yes")}}' . "\n";
//                        $out .= "\t\t\t\t" . '</label>' . "\n";
//                        $out .= "\t\t\t\t" . '</div>';
//                    } else {
//                        if ($value[0] == 'string') {
//                            $out .= "\t\t\t\t" . '<input type="text" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '")  }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
//                        } elseif ($value[0] == 'email') {
//                            $out .= "\t\t\t\t" . '<input type="email" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
//                        } elseif ($value[0] == 'youtube') {
//                            $out .= "\t\t\t\t" . '<input type="url" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
//                        } elseif ($value[0] == 'text') {
//                            $out .= "\t\t\t\t" . '<textarea name="' . $key . '" class="form-control" id="' . $key . '"   placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '")  }}</textarea>' . "\n";
//                        } else {
//                            $out .= "\t\t\t\t" . '<input type="text" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '")  }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
//                        }
//                    }
//                }
//                $out .= "\t\t" . '</div>' . "\n";
//            }
//        }
//        return $out;
//    }

    protected function controllerUpdateImageBeforeStore(){
        $out ='';
        if (count($this->cols) > 0) {
            $files = array_intersect_key($this->cols, getFileFieldsName());
            if(count($files) > 0){
                foreach($files as $key => $file){
                    if(str_contains($key , '[]')){
                        $key  = str_replace('[]' , '' , $key);
                        $out .=  'if ($request->has("oldFiles_'.$key.'") && $request->oldFiles_'.$key.' != "") {
                                        $oldImage_'.$key.' = $request->oldFiles_'.$key.';
                                        $request->request->remove("oldFiles_'.$key.'");
                                    } else {
                                        $oldImage_'.$key.' = json_encode([]);
                                    }'."\n";
                    }
                }
            }
            $out .='$item = $this->storeOrUpdate($request, $id, true);'."\n";
            if(count($files) > 0){
                foreach($files as $key => $file) {
                    if(str_contains($key , '[]')){
                        $key  = str_replace('[]' , '' , $key);
                        $out .='if ($item) {
                                    $image = json_decode($item->'.$key.') ?? [];
                                    $newIamge = json_decode($oldImage_'.$key.') ?? [];
                                    $item_image = array_unique(array_merge($image, $newIamge));
                                    $item->'.$key.' = json_encode($item_image);
                                    $item->save();
                                }'."\n";
                    }
                }
            }
        }else{
            $out .='$item = $this->storeOrUpdate($request, $id, true);'."\n";
        }
        $out .='return redirect()->back();'."\n";
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

    protected function fillValidation()
    {
        $result = '';
        $i = 0;
        foreach ($this->cols as $key => $value) {
            $i++;
            $isMultiLang = isset($value[2]) && $value[2] == 'true' ? '.*' : '';
            $result .= $key . $isMultiLang . ':' . str_replace('|', '_', str_replace(':', '-', $value[1]));
            $result .= count($this->cols) != $i ? ',' : '';
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
        $menu->controller_path = json_encode(["App\Application\Controllers\Admin\\" . $this->getNameInput() . "Controller"]);
        $menu->save();
    }

    protected function addPermissionToAdmin()
    {
        $name = $this->getNameInput();
        $methods = ['index', 'show', 'store', 'update', 'getById', 'destroy' , 'pluck'];
        $id = [];
        foreach ($methods as $method) {
            $array = [
                'name' => $method . "-" . $name . "Controller",
                'slug' => "App-Application-Admin-" . $name . "-Controller" . '-' . $method,
                'description' => "Allow admin on " . $method . " in controller " . $name . " Controller",
                'controller_name' => $name . 'Controller',
                'method_name' => $method,
                'controller_type' => 'admin',
                'namespace' => "App\\Application\\Controllers\\Admin\\" . $name . "Controller",
                'permission' => 1
            ];
            $item = \App\Application\Model\Permission::create($array);
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

    protected function map(){
        $out = "\t\t\t\t".'<div class="pac-card" id="pac-card">'. "\n\t\t\t\t\t";
        $out .= '<div>'. "\n\t\t\t\t\t\t";
        $out .= '<div id="title">'. "\n\t\t\t\t\t\t\t";
        $out .= '{{ trans("admin.Autocomplete search") }}'. "\n\t\t\t\t\t\t";
        $out .= '</div>'. "\n\t\t\t\t\t\t";
        $out .= '<div id="type-selector" class="pac-controls">'. "\n\t\t\t\t\t\t\t";
        $out .= '<input type="radio" name="type" id="changetype-all" checked="checked">'. "\n\t\t\t\t\t\t\t";
        $out .= '<label for="changetype-all">{{ trans("admin.All") }}</label>'. "\n\t\t\t\t\t\t\t";
        $out .= '<input type="radio" name="type" id="changetype-establishment">'. "\n\t\t\t\t\t\t\t";
        $out .= '<label for="changetype-establishment">{{ trans("admin.Establishments") }}</label>'. "\n\t\t\t\t\t\t\t";
        $out .= '<input type="radio" name="type" id="changetype-address">'. "\n\t\t\t\t\t\t\t";
        $out .= '<label for="changetype-address">{{ trans("admin.Addresses") }}</label>'. "\n\t\t\t\t\t\t\t";
        $out .= '<input type="radio" name="type" id="changetype-geocode">'. "\n\t\t\t\t\t\t\t";
        $out .= '<label for="changetype-geocode">{{ trans("admin.Geocodes") }}</label>'. "\n\t\t\t\t\t\t";
        $out .= '</div>'. "\n\t\t\t\t\t\t";
        $out .= ' <div id="strict-bounds-selector" class="pac-controls" > '. "\n\t\t\t\t\t\t\t";
        $out .= '<input type="checkbox" id="use-strict-bounds" value ="" > '. "\n\t\t\t\t\t\t\t";
        $out .= '<label for="use-strict-bounds" > {{ trans("admin.Strict Bounds") }} </label > '. "\n\t\t\t\t\t\t";
        $out .= '</div>'. "\n\t\t\t\t\t\t";
        $out .= '</div>'. "\n\t\t\t\t\t\t";
        $out .= '<div id="pac-container">'. "\n\t\t\t\t\t\t\t";
        $out .= '<input id="pac-input" type="text" placeholder="{{ trans("admin.Enter a location") }}">'."\n\t\t\t\t\t\t";
        $out .= '</div> '."\n\t\t\t\t\t\t";
        $out .= '</div> '."\n\t\t\t\t\t\t";
        $out .= '<div id="map" style="width: 100%;height: 500px;"></div>'."\n\t\t\t\t\t\t";
        $out .= '<div id="infowindow-content">'."\n\t\t\t\t\t\t";
        $out .= ' <img src="" width ="16" height ="16" id="place-icon">'."\n\t\t\t\t\t\t";
        $out .= '<span id="place-name"  class="title"></span><br> '."\n\t\t\t\t\t\t";
        $out .= '<span id="place-address"></span> '."\n\t\t\t\t";
        $out .= '</div>';
        return $out;
    }

}
