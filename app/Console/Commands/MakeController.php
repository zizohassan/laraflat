<?php

namespace App\Console\Commands;


use App\Application\Model\Group;
use App\Console\Commands\Helpers\ControllerTrait;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\File;

class MakeController extends GeneratorCommand
{
    use ControllerTrait;
    
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
                        } elseif ($key == 2) {
                            $this->cols[$value][] = $c;
                        } elseif ($key == 3) {
                            $this->cols[$value][] = $c;
                        }
                    }
                }
            }
            if (!file_exists(app_path('Application/Model/' . ucfirst($this->getNameInput())) . '.php')) {
                $this->call('laraflat:model', ['name' => class_basename($this->getNameInput()), '--cols' => $this->option('cols')]);
            }
        } else {
            if (!file_exists(app_path('Application/Model/' . ucfirst($this->getNameInput())) . '.php')) {
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
        $methods = ['index', 'show', 'store', 'update', 'getById', 'destroy'];
        $id=[];
        foreach ($methods as $method) {
            $array = [
                'name' => 'users-website' . $method . "-" . $name . "Controller",
                'slug' => "App-Application-Admin-" . $name . "-Controller" . '-' . $method,
                'description' => "Allow admin on " . $method . " in controller " . $name . " Controller",
                'controller_name' => $name . 'Controller',
                'method_name' => $method,
                'controller_type' => 'website',
                'namespace' => "App\\Application\\Controllers\\Website\\" . $name . "Controller",
                'permission' => 1
            ];
            $item = \App\Application\Model\Permission::create($array);
            $id[] = $item->id;
        }
        $group = Group::find(2);
        $group->permission()->attach($id);
    }

    protected function addPermission()
    {
        $name = $this->getNameInput();
        $methods = ['index', 'show', 'store', 'update', 'getById', 'destroy'];
        $id=[];
        foreach ($methods as $method) {
            $array = [
                'name' => 'admin-website-' . $method . "-" . $name . "Controller",
                'slug' => "App-Application-Admin-" . $name . "-Controller" . '-' . $method,
                'description' => "Allow admin on " . $method . " in controller " . $name . " Controller",
                'controller_name' => $name . 'Controller',
                'method_name' => $method,
                'controller_type' => 'website',
                'namespace' => "App\\Application\\Controllers\\Website\\" . $name . "Controller",
                'permission' => 1
            ];
            $item = \App\Application\Model\Permission::create($array);
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
            ->replace($stub, 'DummyRequestFilter', $this->getFilters())
            ->replace($stub , 'DummyUpdateFunction' , $this->controllerUpdateImageBeforeStore())
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $controllerName);
    }

    protected function getFilters()
    {
        if (count($this->cols) > 0) {
            $out = '';
            foreach ($this->cols as $key => $filter) {
                if(!in_array($key ,notFilter() )){
                    $f = str_contains($key , '[]') ? str_replace('[]' , '' , $key) : $key;
                    $out .= "\t\t\t".'if(request()->has("' . $f . '") && request()->get("' . $f . '") != ""){'."\n";
                    if($filter[2] == 'true' || str_contains($key , '[]')){
                        $out .= "\t\t\t\t".'$items = $items->where("' . $f . '","like", "%".request()->get("' . $f . '")."%");'."\n";
                    }else{
                        $out .= "\t\t\t\t".'$items = $items->where("' . $f . '","=", request()->get("' . $f . '"));'."\n";
                    }
                    $out .= "\t\t\t".'}' . "\n\n";
                }
            }
            return $out;
        }
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
        $this->CreateOnView('sidebar');
        $this->CreateOnView('homepage');
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
        } elseif ($view == 'sidebar') {
            $path = $this->getPath('Application\\views\\website\\sidebar\\' . strtolower($name) . '.blade');
            $this->files->put($path, $this->buildSideBar($name, __DIR__ . '/stub/views/' . $view . '.stub', $this->sideBarContent($name)));
        } elseif ($view == 'homepage') {
            $path = $this->getPath('Application\\views\\website\\homepage\\' . strtolower($name) . '.blade');
            $this->files->put($path, $this->buildSideBar($name, __DIR__ . '/stub/views/' . $view . '.stub', $this->homePageContent($name)));
        }
    }

    protected function buildFilterForms()
    {
        $name = strtolower($this->getNameInput());
        $out = '';
        $out .=  "\t" . '<form method="get" class="form-inline">'."\n";
        $out .=  "\t\t" . '<div class="form-group">'."\n";
        $out .=  "\t\t\t" . '<input type="text" name="from" class="form-control datepicker2" placeholder=';
        $out .= '"{{ trans("admin.from") }}"';
        $out .= 'value="';
        $out .= '{{ request()->has("from") ? request()->get("from") : "" }}';
        $out .= '">'."\n";
        $out .= "\t\t" . ' </div>'."\n";
        $out .= "\t\t" . '<div class="form-group">'."\n";
        $out .= "\t\t\t" . '<input type="text" name="to" class="form-control datepicker2" placeholder=';
        $out .= '"{{ trans("admin.to") }}"';
        $out .= 'value="';
        $out .= '{{ request()->has("to") ? request()->get("to") : "" }}';
        $out .= '">'."\n";
        $out .= "\t\t" . '</div>'."\n";
        if (count($this->cols) > 0) {
            foreach ($this->cols as $key => $filter) {
                if (!in_array($key, notFilter())) {
                    if ($filter[0] != 'boolean') {
                        if ($key == 'date' || $filter[0] == 'date') {
                            $type = 'text';
                            $class = 'datepicker2';
                        } else if ($key == 'url') {
                            $type = 'url';
                            $class = '';
                        } else if ($key == 'youtube') {
                            $type = 'url';
                            $class = '';
                        }  else if ($key == 'time') {
                            $type = 'text';
                            $class = 'time';
                        }elseif( str_contains($key , '[]')){
                            $key = str_replace('[]' , '' , $key);
                            $type = 'text';
                            $class = '';
                        }else {
                            $type = 'text';
                            $class = '';
                        }
                        $out .= "\t\t" . '<div class="form-group"> ' . "\n";
                        $out .= "\t\t\t" . '<input type="' . $type . '" name="';
                        $out .= $key;
                        $out .= '" class="form-control ' . $class . '" placeholder="';
                        $out .= '{{ trans("' . $name . '.' . $key . '") }}';
                        $out .= '" value="';
                        $out .= '{{ request()->has("' . $key . '") ? request()->get("' . $key . '") : "" }}';
                        $out .= '"> ' . "\n";
                        $out .= "\t\t" . '</div> ' . "\n";
                    } else {
                        $out .= "\t\t" . '<div class="form-group" > ' . "\n";
                        $out .= "\t\t\t" . '<select style="width:80px;" name="';
                        $out .= $key;
                        $out .= '" class="form-control select2" placeholder="';
                        $out .= '{{ trans("' . $name . '.' . $key . '") }}" > ' . "\n";
                        $out .= "\t\t\t\t".'<option>';
                        $out .='{{ trans("'.$name.'.'.$key.'") }}';
                        $out .= '</option>'."\n";
                        $out .= "\t\t\t\t" . '<option value="1" ';
                        $out .= '{{ request()->has("' . $key . '") && request()->get("' . $key . '") == 1 ? "selected" : "" }}';
                        $out .= '>';
                        $out .= '{{trans("' . $name . '.Yes") }}';
                        $out .= ' </option> ' . "\n";
                        $out .= "\t\t\t\t" . '<option value="0" ';
                        $out .= '{{request()->has("' . $key . '") && request()->get("' . $key . '") == 0 ? "selected" : "" }}';
                        $out .= '>';
                        $out .= '{{trans("' . $name . '.No") }}';
                        $out .= ' </option> ' . "\n";
                        $out .= "\t\t\t" . '</select> ' . "\n";
                        $out .= "\t\t" . '</div> ' . "\n";
                    }
                }
            }
            $out .= "\t\t".' <button class="btn btn-success" type="submit" ><i class="fa fa-search" ></i ></button>'."\n";
            $out .= "\t\t".'<a href="{{ url("' . $name . '") }}" class="btn btn-danger" ><i class="fa fa-close" ></i></a>'."\n";
            $out .= "\t".' </form > '."\n";
            return $out;
        }
    }

    protected function sideBarContent($name)
    {
        if (count($this->cols) > 0) {
            $out = '@php $sidebar' . $this->getNameInput() . ' = \\App\\Application\\Model\\' . ucfirst($this->getNameInput()) . '::orderBy("id", "DESC")->limit(5)->get(); @endphp' . "\n";
            $out .= "\t\t" . '@if (count($sidebar' . $this->getNameInput() . ') > 0)' . "\n";
            $out .= "\t\t\t" . '@foreach ($sidebar' . $this->getNameInput() . ' as $d)' . "\n";
            $out .= "\t\t\t\t" . ' <div>' . "\n";
            $i = 0;
            foreach ($this->cols as $key => $value) {
                $i++;
                if ($i <= 1) {
                    $isMultiLang = isset($value[2]) && $value[2] == 'true' ? true : false;
                    if ($value[0] == 'boolean') {
                        $out .= "\t\t\t\t\t" . '{{ $d->' . $key . ' == 1 ? trans("' . strtolower($this->getNameInput()) . '.Yes") : trans("' . strtolower($this->getNameInput()) . '.No")  }}' . "\n";
                    } else if (in_array($key, getFileFieldsName())) {
                        if(in_array($key, getImageFields())){
                            if(str_contains($key , '[]')){
                                $keyWithoutBracktes = str_replace('[]' , '' , $key);
                                $out .= "\t\t\t\t\t" . ' <img src="{{ url(env("SMALL_IMAGE_PATH")."/".getImageFromJson($d ,  "'.$keyWithoutBracktes.'"))}}"  width = "80" />' . "\n";
                            } else{
                                $out .= "\t\t\t\t\t" . ' <img src="{{ url(env("SMALL_IMAGE_PATH")."/".$d->' . $key . ')}}"  width = "80" />' . "\n";
                            }
                        }else{
                            if(str_contains($key , '[]')){
                                $keyWithoutBracktes = str_replace('[]' , '' , $key);
                                $out .= "\t\t\t\t\t" . ' <a href="{{ url(env("UPLOAD_PATH")."/".getImageFromJson($d ,  "'.$keyWithoutBracktes.'"))}}"><i class="fa fa-file"></i></a>' . "\n";
                            } else{
                                $out .= "\t\t\t\t\t" . ' <a href="{{ url(env("UPLOAD_PATH")."/".$d->' . $key . ')}}" ><i class="fa fa-file"></i></a>' . "\n";
                            }
                        }
                    } else {
                        if ($isMultiLang) {
                            if(str_contains($key , '[]')){
                                $key = str_replace('[]' ,'' , $key);
                                $out .= "\t\t\t\t\t" . '<a href="{{ url("' . strtolower($this->getNameInput()) . '/".$d->id."/view") }}" ><p>{{ str_limit(implode("," , json_decode($d->' . $key . ')) , 20) }}</a></p > ' . "\n";
                            }else{
                                $out .= "\t\t\t\t\t" . '<a href="{{ url("' . strtolower($this->getNameInput()) . '/".$d->id."/view") }}" ><p>{{ str_limit(getDefaultValueKey($d->' . $key . ') , 20) }}</a></p > ' . "\n";
                            }
                        } else {
                            if(str_contains($key , '[]')){
                                $key = str_replace('[]' ,'' , $key);
                                $out .= "\t\t\t\t\t" . '<p><a href="{{ url("' . strtolower($this->getNameInput()) . '/".$d->id."/view") }}">{{ str_limit(implode("," , json_decode($d->' . $key . ')) , 20) }}</a></p > ' . "\n";
                            }else{
                                $out .= "\t\t\t\t\t" . '<p><a href="{{ url("' . strtolower($this->getNameInput()) . '/".$d->id."/view") }}">{{ str_limit($d->' . $key . ' , 20) }}</a></p > ' . "\n";
                            }
                        }
                    }
                }
            }
            $out .= "\t\t\t\t\t" . '<p><a href="{{ url("' . strtolower($this->getNameInput()) . '/".$d->id."/view") }}" ><i class="fa fa-eye" ></i ></a> <small ><i class="fa fa-calendar-o" ></i > {{ $d->created_at }}</small ></p > ' . "\n";
            $out .= "\t\t\t\t" . '<hr > ' . "\n";
            $out .= "\t\t\t\t" . '</div> ' . "\n";
            $out .= "\t\t\t" . '@endforeach' . "\n";
            $out .= "\t\t" . '@endif' . "\n\t\t\t";
            return $out;
        }
    }

    protected function homePageContent($name)
    {
        if (count($this->cols) > 0) {
            $out = '@php $sidebar' . $this->getNameInput() . ' = \\App\\Application\\Model\\' . ucfirst($this->getNameInput()) . '::inRandomOrder()->limit(5)->get(); @endphp' . "\n";
            $out .= "\t\t" . '@if (count($sidebar' . $this->getNameInput() . ') > 0)' . "\n";
            $out .= "\t\t\t" . '@foreach ($sidebar' . $this->getNameInput() . ' as $d)' . "\n";
            $out .= "\t\t\t\t" . ' <div>' . "\n";
            $i = 0;
            foreach ($this->cols as $key => $value) {
                $i++;
                if ($i <= 3) {
                    $isMultiLang = isset($value[2]) && $value[2] == 'true' ? true : false;
                    if ($value[0] == 'boolean') {
                        $out .= "\t\t\t\t\t" . '{{ $d->' . $key . ' == 1 ? trans("' . strtolower($this->getNameInput()) . '.Yes") : trans("' . strtolower($this->getNameInput()) . '.No")  }}' . "\n";
                    } else if (in_array($key, getFileFieldsName())) {
                        if(in_array($key, getImageFields())){
                            if(str_contains($key , '[]')){
                                $keyWithoutBracktes = str_replace('[]' , '' , $key);
                                $out .= "\t\t\t\t\t" . ' <img src="{{ url(env("SMALL_IMAGE_PATH")."/".getImageFromJson($d ,"'.$keyWithoutBracktes.'"))}}"  width = "80" />' . "\n";
                            } else{
                                $out .= "\t\t\t\t\t" . ' <img src="{{ url(env("SMALL_IMAGE_PATH")."/".$d->' . $key . ')}}"  width = "80" />' . "\n";
                            }
                        }else{
                            if(str_contains($key , '[]')){
                                $keyWithoutBracktes = str_replace('[]' , '' , $key);
                                $out .= "\t\t\t\t\t" . ' <a href="{{ url(env("UPLOAD_PATH")."/".getImageFromJson($d , "'.$keyWithoutBracktes.'"))}}"><i class="fa fa-file"></i></a>' . "\n";
                            } else{
                                $out .= "\t\t\t\t\t" . ' <a href="{{ url(env("UPLOAD_PATH")."/".$d->' . $key . ')}}" ><i class="fa fa-file"></i></a>' . "\n";
                            }
                        }
                    } else {
                        $start = $i != 1 ? '<p> ' : '<h2 > ';
                        $end = $i != 1 ? '</p > ' : '</h2 > ';
                        $limit = $i == 1 ? 50 : 300;
                        if ($isMultiLang) {
                            if(str_contains($key , '[]')){
                                $key = str_replace('[]' ,'' , $key);
                                $out .= "\t\t\t\t\t" . $start . '{{ str_limit(implode("," , json_decode($d->' . $key . ')) , ' . $limit . ') }}' . $end . "\n";
                            }else{
                                $out .= "\t\t\t\t\t" . $start . '{{ str_limit(getDefaultValueKey($d->' . $key . ') , ' . $limit . ') }}' . $end . "\n";
                            }

                        } else {
                            if(str_contains($key , '[]')){
                                $key = str_replace('[]' ,'' , $key);
                                $out .= "\t\t\t\t\t" . $start . '{{ str_limit(implode("," , json_decode($d->' . $key . ')) , ' . $limit . ') }}' . $end . "\n";
                            }else{
                                $out .= "\t\t\t\t\t" . $start . '{{ str_limit($d->' . $key . ' , ' . $limit . ') }}' . $end . "\n";
                            }
                        }
                    }
                }
            }
            $out .= "\t\t\t\t\t" . ' <p><a href="{{ url("' . strtolower($this->getNameInput()) . '/".$d->id."/view") }}" ><i class="fa fa-eye" ></i ></a> <small ><i class="fa fa-calendar-o" ></i > {{ $d->created_at }}</small ></p > ' . "\n";
            $out .= "\t\t\t\t" . '<hr > ' . "\n";
            $out .= "\t\t\t\t" . '</div> ' . "\n";
            $out .= "\t\t\t" . '@endforeach' . "\n";
            $out .= "\t\t" . '@endif' . "\n\t\t\t";
            return $out;
        }
    }

    protected function CreateButton($view)
    {
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\views\\website\\' . strtolower($this->getNameInput()) . '\\buttons\\' . $view . '.blade');
        $this->line('Done create action button view at Application view website ' . $this->getNameInput() . 'button');
        $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/views/buttons/' . $view . '.stub'));
    }

    protected function buildSideBar($name, $stub, $table = null)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DUMMYHEADER', $name)
            ->replaceView($stub, 'DUMMYCONTENT', $table);
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
                $out .= "\t\t" . ' <div class="form-group" > ' . "\n";
                $k = str_contains( $key , '[]') ? str_replace('[]' ,'', $key) : $key;
                $out .= "\t\t\t" . '<label for="' . $k . '">{{ trans("' . strtolower($this->getNameInput()) . '.' . $k . '")}}</label>' . "\n";
                if (in_array($key, getFileFieldsName())) {
                    if(str_contains($key , '[]')){
                        $out .= $this->inputAsArray($key , 'file');
                    }else{
                        $out .= "\t\t\t\t" . '@if(isset($item) && $item->' . $key . ' != "")' . "\n";
                        $out .= "\t\t\t\t" . '<br>' . "\n";
                        $out .= "\t\t\t\t" . '<img src="{{ url(env("SMALL_IMAGE_PATH")."/".$item->' . $key . ') }}" class="thumbnail" alt="" width="200">' . "\n";
                        $out .= "\t\t\t\t" . '<br>' . "\n";
                        $out .= "\t\t\t\t" . "@endif" . "\n";
                        $out .= "\t\t\t\t" . '<input type="file" name="' . $key . '" >' . "\n";
                    }
                } elseif ($key == 'youtube') {
                    $out .= "\t\t\t\t" . '@if(isset($item) && $item->' . $key . ' != "")' . "\n";
                    $out .= "\t\t\t\t" . ' <br>' . "\n";
                    $out .= "\t\t\t\t" . ' <iframe width = "420" height = "315" src="https://www.youtube.com/embed/{{ isset($item->' . $key . ') ? getYouTubeId($item->' . $key . ') : old("' . $key . '")  }}" ></iframe > ' . "\n";
                    $out .= "\t\t\t\t" . '<br > ' . "\n";
                    $out .= "\t\t\t\t" . "@endif" . "\n";
                    $out .= "\t\t\t\t" . '<input type="url" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '")  }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
                } elseif ($key == 'icon') {
                    $out .= "\t\t\t\t" . '<input type="text" name="' . $key . '" class="form-control icon-field" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
                } elseif ($key == 'url') {
                    $out .= "\t\t\t\t" . '<input type="url" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
                } elseif ($key == 'date') {
                    $out .= "\t\t\t\t" . ' <input type="text" name="' . $key . '" class="form-control datepicker2" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
                }elseif ($key == 'time') {
                    $out .= "\t\t\t\t" . ' <input type="text" name="' . $key . '" class="form-control time" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
                }elseif ($key == 'lat') {
                    $out .= "\t\t\t\t" . ' <input type="text" name="' . $key . '" class="form-control lat" style="display:none" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
                    $out .= $this->map();
                }elseif ($key == 'lng') {
                    $out .= "\t\t\t\t" . ' <input type="text" name="' . $key . '" class="form-control lng" style="display:none" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" > ' . "\n";
                }elseif (str_contains($key , '[]')) {
                    $out .= $this->inputAsArray($key);
                } else {
                    if ($value[0] == 'string' && $isMultiLang) {
                        $out .= "\t\t\t\t" . '{!! extractFiled("' . $key . '", isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") , "text" , "' . strtolower($this->getNameInput()) . '") !!}' . "\n";
                    } elseif ($value[0] == 'email' && $isMultiLang) {
                        $out .= "\t\t\t\t" . '{!! extractFiled("' . $key . '", isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") , "email" , "' . strtolower($this->getNameInput()) . '") !!}' . "\n";
                    } elseif ($value[0] == 'date' && $isMultiLang) {
                        $out .= "\t\t\t\t" . '{!! extractFiled("' . $key . '", isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") , "date" , "' . strtolower($this->getNameInput()) . '" , "datepicker") !!}' . "\n";
                    } elseif ($value[0] == 'text' && $isMultiLang) {
                        $out .= "\t\t\t\t" . '{!! extractFiled("' . $key . '", isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") , "textarea" , "' . strtolower($this->getNameInput()) . '" ) !!}' . "\n";
                    } elseif ($value[0] == 'boolean') {
                        $out .= "\t\t\t\t" . ' <div class="form-check">' . "\n";
                        $out .= "\t\t\t\t\t" . '<label class="form-check-label">' . "\n";
                        $out .= "\t\t\t\t\t" . '<input class="form-check-input" name="' . $key . '" {{ isset($item->' . $key . ') && $item->' . $key . ' == 0 ? "checked" : "" }} type="radio" value="0" > ' . "\n";
                        $out .= "\t\t\t\t\t" . '{{ trans("' . strtolower($this->getNameInput()) . '.No")}}' . "\n";
                        $out .= "\t\t\t\t" . ' </label > ' . "\n";
                        $out .= "\t\t\t\t" . '<label class="form-check-label">' . "\n";
                        $out .= "\t\t\t\t" . '<input class="form-check-input" name="' . $key . '" {{ isset($item->' . $key . ') && $item->' . $key . ' == 1 ? "checked" : "" }} type="radio" value="1" > ' . "\n\t\t\t\t";
                        $out .= "\t\t\t\t\t" . '{{ trans("' . strtolower($this->getNameInput()) . '.Yes")}}' . "\n";
                        $out .= "\t\t\t\t" . ' </label> ' . "\n";
                        $out .= "\t\t\t\t" . '</div> ';
                    } else {
                        if ($value[0] == 'string') {
                            $out .= "\t\t\t\t" . '<input type="text" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
                        } elseif ($value[0] == 'email') {
                            $out .= "\t\t\t\t" . '<input type="email" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
                        } elseif ($value[0] == 'youtube') {
                            $out .= "\t\t\t\t" . '<input type="url" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
                        } elseif ($value[0] == 'date') {
                            $out .= "\t\t\t\t" . '<input type="date" name="' . $key . '" class="form-control datepicker" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">' . "\n";
                        } elseif ($value[0] == 'text') {
                            $out .= "\t\t\t\t" . '<textarea name="' . $key . '" class="form-control" id="' . $key . '"   placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}" >{{isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}</textarea >'."\n";
                        } else {
                            $out .= "\t\t\t\t" . '<input type="text" name="' . $key . '" class="form-control" id="' . $key . '" value="{{ isset($item->' . $key . ') ? $item->' . $key . ' : old("' . $key . '") }}"  placeholder="{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '")}}">'."\n";
                        }
                    }
                }
                $out .= "\t\t" . '</div>' . "\n";
            }
        }
        return $out;
    }

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

    protected function renderShow($name)
    {
        $out = '';
        if (count($this->cols) > 0) {
            $tableClass = env('THEME') == 'themeone' ? '' : 'table-responsive';
            $out .= "\t\t" . ' <table class="table table-bordered '.$tableClass.' table-striped" > ' . "\n";
            foreach ($this->cols as $key => $value) {
                $isMultiLang = isset($value[2]) && $value[2] == 'true' ? true : false;
                $k = $key;
                $key = str_contains($key , '[]') ? str_replace('[]' , '' , $key) : $key;
                $out .= "\t\t\t\t" . ' <tr>' . "\n\t\t\t\t" . ' <th>{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '") }}</th> ' . "\n";
                $out .= "\t\t\t\t" . '@php $type = getFileType("' . $key . '", $item->' . $key . ') @endphp' . "\n";
                $out .= "\t\t\t\t" . '@if ($type == "File") ' . "\n";
                $out .= "\t\t\t\t\t" . ' <td> <a href="{{ url(env("UPLOAD_PATH")."/".$item->' . $key . ') }}" >{{ $item->' . $key . ' }}</a></td> ' . "\n";
                $out .= "\t\t\t\t" . '@elseif($type == "Image")' . "\n";
                $out .= "\t\t\t\t\t" . ' <td> <img src="{{ url(env("SMALL_IMAGE_PATH")."/".$item->' . $key . ') }}" /></td> ' . "\n";
                $out .= "\t\t\t\t" . '@else' . "\n";
                if ($k == 'youtube') {
                    $out .= "\t\t\t\t" . '@if (isset($item) && $item->' . $key . ' != "")' . "\n";
                    $out .= "\t\t\t\t\t" . ' <td>' . "\n";
                    $out .= "\t\t\t\t" . ' <iframe width = "420" height = "315" src="https://www.youtube.com/embed/{{ isset($item->' . $key . ') ? getYouTubeId($item->' . $key . ') : old("' . $key . '")  }}" ></iframe > ' . "\n";
                    $out .= "\t\t\t\t\t" . '</td> ' . "\n";
                    $out .= "\t\t\t\t" . "@endif" . "\n";
                } else if ($value[0] == 'boolean') {
                    $out .= "\t\t\t\t\t" . ' <td>' . "\n";
                    $out .= "\t\t\t\t" . '{{ $item->' . $key . ' == 1 ? trans("' . strtolower($this->getNameInput()) . '.Yes") : trans("' . strtolower($this->getNameInput()) . '.No")  }}' . "\n";
                    $out .= "\t\t\t\t\t" . ' </td> ' . "\n";
                } else if ($k == 'url') {
                    $out .= "\t\t\t\t\t" . ' <td>' . "\n";
                    $out .= "\t\t\t\t" . ' <a href="{{  $item->' . $key . ' }}" ><i class="fa fa-link" ></i ></a> ' . "\n";
                    $out .= "\t\t\t\t\t" . '</td> ' . "\n";
                } else if ($k == 'icon') {
                    $out .= "\t\t\t\t\t" . ' <td>' . "\n";
                    $out .= "\t\t\t\t" . ' <i class="fa {{ $item->' . $key . '}}" ></i> ' . "\n";
                    $out .= "\t\t\t\t\t" . '</td> ' . "\n";
                }else if(str_contains($k , '[]')){
                    if (in_array($k, getFileFieldsName())) {
                        $out .= "\t\t\t\t\t" . '<td>' . "\n";
                        $out .= "\t\t\t\t\t" . '@isset($item)' . "\n";
                        $out .= "\t\t\t\t\t\t" . '@if(json_decode($item->' . $key . '))' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '<input type="hidden" name="oldFiles_' . $key . '" value="{{ $item->' . $key . ' }}">' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '@php $files = returnFilesImages($item , "' . $key . '"); @endphp' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '<div class="row text-center">' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '@foreach($files["image"] as $jsonimage )' . "\n";
                        $out .= "\t\t\t\t\t\t\t\t" . '<div class="col-lg-2 text-center"><img src="{{ url(env("SMALL_IMAGE_PATH")."/".$jsonimage) }}" class="img-responsive" /><br>' . "\n";
                        $out .= "\t\t\t\t\t\t\t\t" . '<a class="btn btn-danger" href="{{ url("deleteFile/' . strtolower($this->getNameInput()) . '/".$item->id."?name=".$jsonimage."&filed_name=' . $key . '") }}"><i class="fa fa-trash"></i></a></div>' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '@endforeach' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '</div>' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '<div class="row text-center">' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '@foreach($files["file"] as $jsonimage )' . "\n";
                        $out .= "\t\t\t\t\t\t\t\t" . '<div class="col-lg-2 text-center"><a href="{{ url(env("UPLOAD_PATH")."/".$jsonimage) }}" ><i class="fa fa-file"></i></a>' . "\n";
                        $out .= "\t\t\t\t\t\t\t\t" . '<a  href="{{ url("deleteFile/' . strtolower($this->getNameInput()) . '/".$item->id."?name=".$jsonimage."&filed_name=' . $key . '") }}"><i class="fa fa-trash"></i> {{ $jsonimage }} </a></div>' . "\n";
                        $out .= "\t\t\t\t\t\t\t" . '@endforeach' . "\n";
                        $out .= "\t\t\t\t\t" . '</div>' . "\n";
                        $out .= "\t\t\t\t\t\t" . '@endif' . "\n";
                        $out .= "\t\t\t\t\t" . '@endisset' . "\n";
                        $out .= "\t\t\t\t\t" . '</td>' . "\n";
                    }else{
                        $out .= "\t\t\t\t\t". '<td><span class="label label-default">{!! implode("</span> <br> <span class=';
                        $out .= "'label label-default'";
                        $out .= '>" , json_decode($item->' . $key . ')) !!}</span></td> ' . "\n\t\t\t\t";
                    }
                }else if ($k == 'lat') {
                    $out .= "\t\t\t\t\t" . '<td>' . "\n";
                    $out .= "\t\t\t\t" . '{{nl2br($item->' . $key . ') }}' . "\n";
                    $out .= "\t\t\t\t\t" . '</td></tr><tr>{{ trans("admin.location") }}<th></th>' . "\n";
                    $out .= "\t\t\t\t\t" . '<td>' . "\n";
                    $out .= "\t\t\t\t" . '<div id="showMap" style="width:100%;height: 500px;" data-lat="{{ $item->lat }}"  data-lng="{{ $item->lng }}"></div>' . "\n";
                    $out .= "\t\t\t\t\t" . '</td>' . "\n";
                }else if(str_contains($k , '[]')){
                    $out .= '<td><span class="label label-default">{!! implode("</span> <br> <span class=';
                    $out .= "'label label-default'";
                    $out .= '>" , json_decode($item->' . $key . ')) !!}</span></td> ' . "\n\t\t\t\t";
                } else {
                    if ($isMultiLang) {
                        $out .= "\t\t\t\t\t" . '<td>{{ getDefaultValueKey(nl2br($item->' . $key . ')) }}</td> ' . "\n";
                    } else {
                        $out .= "\t\t\t\t\t" . '<td>{{nl2br($item->' . $key . ') }}</td> ' . "\n";
                    }
                }
                $out .= "\t\t\t\t" . '@endif</tr> ' . "\n";
            }
            $out .= "\t\t" . '</table > ' . "\n";
        } else {
            $out .= "\t\t" . '<table class="table table-bordered table-responsive table-striped" > ' . "\n";
            $out .= "\t\t" . '@php' . "\n";
            $out .= "\t\t" . '$fields = rename_keys(' . "\n";
            $out .= "\t\t" . 'removeFromArray($item["fields"], ["updated_at"]) ,' . "\n";
            $out .= "\t\t" . '["UserName"]' . "\n";
            $out .= "\t\t" . ');' . "\n";
            $out .= "\t\t" . '@endphp' . "\n";
            $out .= "\t\t" . '@foreach ($fields as $key => $field) ' . "\n";
            $out .= "\t\t\t" . ' <tr>' . "\n";
            $out .= "\t\t\t\t" . ' <th>{{ $key }}</th> ' . "\n";
            $out .= "\t\t\t\t" . '@php $type = getFileType($field, $item[$field]) @endphp' . "\n";
            $out .= "\t\t\t\t" . '@if ($type == "File") ' . "\n";
            $out .= "\t\t\t\t\t" . ' <td> <a href="{{ url(env("UPLOAD_PATH")."/".$item[$field]) }}" >{{ $item[$field] }}</a></td> ' . "\n";
            $out .= "\t\t\t\t" . '@elseif($type == "Image")' . "\n";
            $out .= "\t\t\t\t\t" . ' <td> <img src="{{ url(env("SMALL_IMAGE_PATH")."/".$item[$field]) }}" /></td> ' . "\n";
            $out .= "\t\t\t\t" . '@else' . "\n";
            $out .= "\t\t\t\t\t" . ' <td> {!!getDefaultValueKey(nl2br($item[$field]))  !!}</td> ' . "\n";
            $out .= "\t\t\t\t" . '@endif' . "\n";
            $out .= "\t\t\t" . ' </tr> ' . "\n";
            $out .= "\t\t" . '@endforeach' . "\n";
            $out .= "\t\t" . ' </table > ' . "\n";
        }
        return $out;

    }

    protected function homePage($name)
    {

    }

    protected function renderTable($name)
    {

        $out = $this->buildFilterForms();

        $out .= '<br ><table class="table table-responsive table-striped table-bordered"> ' . "\n\t\t";
        $out .= '<thead > ' . "\n\t\t\t";
        if (count($this->cols) > 0) {
            $out .= '<tr> ' . "\n\t\t\t\t";
            foreach ($this->cols as $key => $value) {
                if(str_contains($key , '[]')){
                    $key = str_replace('[]' , '' , $key);
                }
            $out .= '<th>{{ trans("' . strtolower($this->getNameInput()) . '.' . $key . '") }}</th> ' . "\n\t\t\t\t";}
            $out .= '<th>{{ trans("' . strtolower($this->getNameInput()) . '.edit") }}</th> ' . "\n\t\t\t\t";
            $out .= '<th>{{ trans("' . strtolower($this->getNameInput()) . '.show") }}</th> ' . "\n\t\t\t\t";
            $out .= '<th>{{
            trans("' . strtolower($this->getNameInput()) . '.delete") }}</th> ' . "\n\t\t\t\t";
        } else {
            $out .= '<tr><th></th></tr> ' . "\n\t\t\t\t";
        }
        $out .= '</thead > ' . "\n\t\t";
        $out .= '<tbody > ' . "\n\t\t";
        $out .= '@if (count($items) > 0) ' . "\n\t\t\t";
        $out .= '@foreach ($items as $d) ' . "\n\t\t\t\t";
        if (count($this->cols) > 0) {
            $out .= ' <tr>' . "\n\t\t\t\t\t";
            foreach ($this->cols as $key => $value) {
                $isMultiLang = isset($value[2]) && $value[2] == 'true' ? true : false;
                if ($value[0] == 'boolean') {
                    $out .= "\t\t\t\t\t" . ' <td>' . "\n";
                    $out .= "\t\t\t\t" . '{{ $d->' . $key . ' == 1 ? trans("' . strtolower($this->getNameInput()) . '.Yes") : trans("' . strtolower($this->getNameInput()) . '.No")  }}' . "\n";
                    $out .= "\t\t\t\t\t" . ' </td> ' . "\n";
                } else if(str_contains($key , '[]') && !in_array($key, getFileFieldsName())){
                    $key = str_replace('[]' , '' , $key);
                    $out .= '<td><span class="label label-default">{!! implode("</span><br><span class=';
                    $out .= "'label label-default'";
                    $out .= '>" , json_decode($d->' . $key . ')) !!}</span></td> ' . "\n\t\t\t\t";
                } else if (in_array($key, getFileFieldsName())) {
                    $out .= "\t\t\t\t\t" . ' <td>' . "\n";
                    if(in_array($key, getImageFields())){
                        if(str_contains($key , '[]')){
                            $keyWithoutBracktes = str_replace('[]' , '' , $key);
                            $out .= "\t\t\t\t\t" . ' <img src="{{ url(env("SMALL_IMAGE_PATH")."/".getImageFromJson($d ,"'.$keyWithoutBracktes.'"))}}"  width = "80" />' . "\n";
                        } else{
                            $out .= "\t\t\t\t\t" . ' <img src="{{ url(env("SMALL_IMAGE_PATH")."/".$d->' . $key . ')}}"  width = "80" />' . "\n";
                        }
                    }else{
                        if(str_contains($key , '[]')){
                            $keyWithoutBracktes = str_replace('[]' , '' , $key);
                            $out .= "\t\t\t\t\t" . ' <a href="{{ url(env("UPLOAD_PATH")."/".getImageFromJson($d , "'.$keyWithoutBracktes.'"))}}"><i class="fa fa-file"></i></a>' . "\n";
                        } else{
                            $out .= "\t\t\t\t\t" . ' <a href="{{ url(env("UPLOAD_PATH")."/".$d->' . $key . ')}}" ><i class="fa fa-file"></i></a>' . "\n";
                        }
                    }
                    $out .= "\t\t\t\t\t" . ' </td> ' . "\n";
                } else if ($key  == 'icon') {
                    $out .= "\t\t\t\t\t" . '<td> ' . "\n";
                    $out .= "\t\t\t\t" . '<i class="fa {{ $d->'.$key.' }}"></i>' . "\n";
                    $out .= "\t\t\t\t\t" . '</td> ' . "\n";
                } else if ($key  == 'url') {
                    $out .= "\t\t\t\t\t" . '<td> ' . "\n";
                    $out .= "\t\t\t\t" . '<a href="{{ $d->'.$key.' }}"><i class="fa fa-link }}"></i></a>' . "\n";
                    $out .= "\t\t\t\t\t" . '</td> ' . "\n";
                }else {
                    if ($isMultiLang) {
                        $out .= '<td>{{str_limit(getDefaultValueKey($d->' . $key . ') , 20) }}</td> ' . "\n\t\t\t\t";
                    } else {
                        $out .= '<td>{{ str_limit($d->' . $key . ' , 20) }}</td> ' . "\n\t\t\t\t";
                    }
                }
            }
            $out .= '<td> @include("website.' . $name . '.buttons.edit", ["id" => $d->id])</td> ' . "\n\t\t\t\t\t";
            $out .= '<td> @include("website.' . $name . '.buttons.view", ["id" => $d->id])</td> ' . "\n\t\t\t\t\t";
            $out .= '<td> @include("website.' . $name . '.buttons.delete", ["id" => $d->id])</td> ' . "\n\t\t\t\t\t";
            $out .= '</tr> ' . "\n\t\t\t\t\t";
        } else {
            $out .= '<tr><th></th></tr> ' . "\n\t\t\t\t\t";
        }
        $out .= '@endforeach' . "\n\t\t\t\t";
        $out .= '@endif' . "\n\t\t\t";
        $out .= ' </tbody > ' . "\n\t\t";
        $out .= '</table > ' . "\n\t";
        $out .= '@include(layoutPaginate() , ["items" => $items])' . "\n\t\t";
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
