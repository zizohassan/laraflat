<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class MakeApiController extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:laraflat_api_controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create  APi Controller in application path';



    public function handle(){
        $this->makeApiClass();
        $this->routeApi();
    }


    ////api
    protected function makeApiClass(){
        $name = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath('Application\\Controllers\\Api\\'.$this->getNameInput().'Api');
        $this->line('Done create Api Class  at Application Controllers Api  '.$this->getNameInput() .'Api .');
        $this->files->put($path, $this->buildApi($name));
    }

    protected function getStub()
    {
        return __DIR__.'/stub/api/apiclass.stub';
    }


    protected function buildApi($name){
        $stub = $this->files->get($this->getStub());
        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /////api

    ///api routes
    protected function routeApi(){
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\routes\\appendApi');
        $this->line('Done append routes to route file at Application route  appendApi .');
        $this->files->append($path, $this->apiRoute( $name  , __DIR__.'/stub/api/route.stub'));
    }

    protected function apiRoute($name  , $stub ){
        $stub = $this->files->get($stub);
        return $this->replace( $stub, 'DummyRoute',$name)
            ->replaceView( $stub, 'DummyView',ucfirst($name));
    }

    ///api routes


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

}
