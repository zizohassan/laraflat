<?php

namespace App\Console\Commands;

use App\Application\Model\Group;
use App\Application\Model\Item;
use App\Application\Model\Permission;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\Console\Input\InputArgument;

class MakeAdminModel extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laraflat:admin_model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will generate model , controller , view , migration , datatable class for you';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->addlanguageFile();
        $this->call('laraflat:admin_controller', ['name' => class_basename($this->getNameInput()), '--cols' => $this->option('cols')]);
        $this->call('laraflat:controller', ['name' => class_basename($this->getNameInput()), '--cols' => $this->option('cols')]);
        $this->call('laraflat:api_controller', ['name' => class_basename($this->getNameInput()), '--cols' => $this->option('cols')]);
    }


    protected function addlanguageFile()
    {
        $name = strtolower($this->getNameInput());
        $locales = LaravelLocalization::getSupportedLocales();
        foreach ($locales as $key => $locale) {
            $this->line('Create  ' . $locale['name'] . ' Language file .');
            $path = base_path('resources/lang/' . $key . '/' . $name . '.php');
            $this->files->put($path, $this->buildlang($name, __DIR__ . '/stub/lang.stub'));
        }
        return 'Done';
    }


    protected function buildlang($name, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replaceView($stub, 'DUMMYKEY', $name);
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



    /*
     * Make Request For admin
     */


    protected function makeRequest($requestType = 'AddRequest')
    {
        $ds = DIRECTORY_SEPARATOR;
        $name = ucfirst($this->getNameInput());
        $folderName = ucfirst($this->getNameInput());
        $pathFile = app_path('Application' . $ds . 'Requests' . $ds . 'Admin' . $ds . $folderName);
        if (!file_exists($pathFile)) {
            File::makeDirectory($pathFile, 0775, true);
        }
        if ($requestType == 'AddRequest') {
            $file = __DIR__ . '/stub/addrequest.stub';
        } else {
            $file = __DIR__ . '/stub/updaterequest.stub';
        }
        $path = $this->getPath('Application\\Requests\\Admin\\' . $folderName . '\\' . $requestType . $name);
        $this->line('Done create Request class  at Application   ' . $requestType . $this->getNameInput());
        $this->files->put($path, $this->buildRequest($name, 'Admin\\' . $folderName, $file));
    }


    protected function buildRequest($name, $nameDatatable, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DummyFolder', $nameDatatable)
            ->replaceView($stub, 'DummyName', ucfirst($name));
    }


    /*
    * Make Request For admin
    */


    protected function addItemtoMenue()
    {
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\views\\admin\\layout\\menu.blade');
        $this->line('Done append item  to menu file at Application  .');
        $this->files->append($path, $this->buildMenu($name, __DIR__ . '/stub/menu.stub'));
    }


    protected function buildMenu($name, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DummyModel', $name)
            ->replaceView($stub, 'DummyNameBigs', ucfirst($name));
    }


    protected function createMigration()
    {
        $table = Str::plural(Str::snake(class_basename($this->argument('name'))));
        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table
        ]);
    }

    protected function createDataTable()
    {
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\DataTables\\' . $this->getNameInput() . 'sDataTable');
        $nameDatatable = $this->getNameInput() . 'sDataTable';
        $this->line('Done create Datatable class  at Application DataTables  ' . $this->getNameInput() . 'sDatatable .');
        $this->files->put($path, $this->buildDataTable($name, $nameDatatable, __DIR__ . '/stub/datatable.stub'));
    }






    protected function buildDataTable($name, $nameDatatable, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DummyDatatable', $nameDatatable)
            ->replace($stub, 'DummyModelSmall', strtolower($name))
            ->replaceView($stub, 'DummyModel', ucfirst($name));
    }


    /*
     * Model
     */
    protected function createModel()
    {
        $name = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath('Application\\Model\\' . $this->getNameInput());
        $this->line('Done create Model  at Application Model  ' . $this->getNameInput() . ' .');
        $this->files->put($path, $this->buildClass($name));
    }


    protected function getStub()
    {
        return __DIR__ . '/stub/model.stub';
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        return $this->replace($stub, 'DummyTable', Str::plural(strtolower($this->getClassNameFormNameSpace($name))))
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);
    }


    protected function getClassNameFormNameSpace($nameSpace)
    {
        return substr(strrchr($nameSpace, "\\"), 1);
    }

    /*
    * Model
    */

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

    protected function buildClassController($name, $controllerName, $dataTableName, $modelName, $viewName, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DummyModel', $modelName)
            ->replace($stub, 'DummyDataTable', $dataTableName)
            ->replace($stub, 'DummyView', $viewName)
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $controllerName);
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'App';
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
        $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/adminViews/' . $view . '.stub'));
    }

    protected function CreateButton($view)
    {
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\views\\admin\\' . strtolower($this->getNameInput()) . '\\buttons\\' . $view . '.blade');
        $this->line('Done create action button view at Application view admin ' . $this->getNameInput() . ' button');
        $this->files->put($path, $this->buildView($name, __DIR__ . '/stub/adminViews/buttons/' . $view . '.stub'));
    }

    protected function buildView($name, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replaceView($stub, 'DummyView', $name);
    }


    ////api
    protected function makeApiClass()
    {
        $name = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath('Application\\Controllers\\Api\\' . $this->getNameInput() . 'Api');
        $this->line('Done create Api Class  at Application Controllers Api  ' . $this->getNameInput() . 'Api .');
        $this->files->put($path, $this->buildApi($name));
    }

    protected function getStubApi()
    {
        return __DIR__ . '/stub/api/apiclass.stub';
    }


    protected function buildApi($name)
    {
        $stub = $this->files->get($this->getStubApi());
        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /////api

    ///api routes
    protected function routeApi()
    {
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\routes\\appendApi');
        $this->line('Done append routes to route file at Application route  appendApi .');
        $this->files->append($path, $this->apiRoute($name, __DIR__ . '/stub/api/route.stub'));
    }

    protected function apiRoute($name, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DummyRoute', $name)
            ->replaceView($stub, 'DummyView', ucfirst($name));
    }

    ///api routes

    ///transformer
    protected function makeTransformer()
    {
        $name = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath('Application\\Transformers\\' . $this->getNameInput() . 'Transformers');
        $this->line('Done create Api Class  at Application Transformers for api  ' . $this->getNameInput() . 'Transformers .');
        $this->files->put($path, $this->buildTransformers($name));
    }

    protected function getTransformer()
    {
        return __DIR__ . '/stub/api/transformer.stub';
    }

    protected function buildTransformers($name)
    {
        $stub = $this->files->get($this->getTransformer());
        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    ////transformer

    protected function getOptions()
    {
        return [
            ['cols', 'c', InputArgument::OPTIONAL, 'Set Model Fillable , request , migration columns']
        ];
    }
}
