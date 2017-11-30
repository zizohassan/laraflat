<?php

namespace App\Console\Commands;


use Illuminate\Console\GeneratorCommand;

class MakeInterfaceEloquent extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:interface';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create  Interface Class and Eloquent class implement the interface in application path';



    public function handle(){
        $this->createInterface();
        $this->createEloquent();
        $this->appendToBindProvider();
    }


    protected function createInterface()
    {
        $name = $this->qualifyClass(strtolower($this->getNameInput()));
        $controllerName = $this->getNameInput().'Interface';
        $path = $this->getPath('Application\\Repository\\InterFaces\\'.$this->getNameInput().'InterFace');
        $this->line('Done Create InterFaces  at Application Repository InterFaces '.$this->getNameInput() .'InterFaces .');
        $this->files->put($path, $this->buildClassInterface( $name , $controllerName ,$this->getStub()));
    }

    protected function createEloquent(){
        $name = $this->qualifyClass(strtolower($this->getNameInput()));
        $EloquentName = $this->getNameInput().'Eloquent';
        $InterfaceName = $this->getNameInput().'Interface';
        $path = $this->getPath('Application\\Repository\\Eloquent\\'.$this->getNameInput().'Eloquent');
        $this->line('Done Create Eloquent  at Application Repository Eloquent '.$this->getNameInput() .' Eloquent .');
        $this->files->put($path, $this->buildClassEloquent( $name , $EloquentName , $InterfaceName ,$this->getStubEloquent()));
    }

    protected function getStub()
    {
        return  __DIR__.'/stub/interface.stub';
    }

    protected function getStubEloquent()
    {
        return  __DIR__.'/stub/eloquent.stub';
    }

    protected function buildClassInterface($name ,$EloquentName , $stub){
        $stub = $this->files->get($stub);
        return $this->replaceNamespace($stub, $name)
            ->replaceClass($stub, $EloquentName);
    }

    protected function buildClassEloquent($name ,$EloquentName ,$InterfaceName , $stub){
            $stub = $this->files->get($stub);
            return $this->replace( $stub,'DummyInterface' ,  $InterfaceName)
                ->replaceNamespace($stub, $name)
                ->replaceClass($stub, $EloquentName);
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

    protected function appendToBindProvider(){
        $EloquentName = $this->getNameInput().'Eloquent';
        $InterfaceName = $this->getNameInput().'Interface';
        $path = $this->getPath('Providers\\ExtraInterfaces');
        $this->line('Done append To Bind Provider .');
        $this->files->append($path, $this->buildBind( $EloquentName ,  $InterfaceName , __DIR__.'/stub/bind.stub'));
    }


    protected function buildBind(  $EloquentName ,  $InterfaceName , $stub ){
        $stub = $this->files->get($stub);
        return $this->replace( $stub, 'DummyEloquent',$EloquentName)
            ->save( $stub, 'DummyInterface',$InterfaceName);
    }


    protected function save(&$stub,$rep ,  $name)
    {
        $stub = str_replace(
            [$rep],
            $name,
            $stub
        );
        return $stub;
    }

}
