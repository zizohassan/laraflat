<?php

namespace App\Console\Commands;


use Illuminate\Console\GeneratorCommand;

class MakeAdminController extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:laraflat_admin_controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create Admin Controller in application path';



    public function handle(){
        $this->createController();
    }


    protected function createController()
    {
        $name = $this->qualifyClass(strtolower($this->getNameInput()));
        $controllerName = $this->getNameInput().'Controller';
        $path = $this->getPath('Application\\Controllers\\Admin\\'.$this->getNameInput().'Controller');
        $this->line('Done create Controller  at Application controller admin '.$this->getNameInput() .'Controller .');
        $this->files->put($path, $this->buildClassController( $name , $controllerName ,$this->getStub()));

    }

    protected function getStub()
    {
        return  __DIR__.'/stub/admincontroller.stub';
    }


    protected function buildClassController($name ,$controllerName , $stub){
        $stub = $this->files->get($stub);
        return $this->replaceNamespace($stub, $name)
            ->replaceClass($stub, $controllerName);
    }


}
