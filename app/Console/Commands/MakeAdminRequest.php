<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;

class MakeAdminRequest extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:laraflat_admin_request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create Admin Request in application path';



    public function handle(){
        $this->makeRequest();
        $this->makeRequest('UpdateRequest');
    }




    protected function makeRequest($requestType = 'AddRequest')
    {
        $ds = DIRECTORY_SEPARATOR;
        $name = ucfirst($this->getNameInput());
        $folderName = ucfirst($this->getNameInput());
        $pathFile = app_path('Application'.$ds.'Requests'.$ds.'Admin'.$ds.$folderName);
        if(!file_exists($pathFile)){
            File::makeDirectory($pathFile, 0775, true);
        }
        if($requestType == 'AddRequest'){
            $file =   __DIR__.'/stub/addrequest.stub';
        }else{
            $file =   __DIR__.'/stub/updaterequest.stub';
        }
        $path = $this->getPath('Application\\Requests\\Admin\\'.$folderName.'\\'.$requestType.$name);
        $this->line('Done create Request class  at Application   '.$requestType.$this->getNameInput());
        $this->files->put($path, $this->buildRequest( $name ,  'Admin\\'.$folderName  , $file));
    }



    protected function buildRequest($name  , $nameDatatable  , $stub ){
        $stub = $this->files->get($stub);
        return $this->replace( $stub, 'DummyFolder',$nameDatatable)
            ->replaceView( $stub, 'DummyName',ucfirst($name));
    }


    protected function replace(&$stub,$rep ,  $name)
    {
        $stub = str_replace(
            [$rep],
            $name,
            $stub
        );

        return $this;
    }

    protected function replaceView(&$stub,$rep ,  $name)
    {
        $stub = str_replace(
            [$rep],
            $name,
            $stub
        );
        return $stub;
    }


    protected function getStub()
    {

    }


}
