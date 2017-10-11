<?php

namespace App\Console\Commands;


use Illuminate\Console\GeneratorCommand;

class MakeTransformer extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:laraflat_transformer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create  Transformer in application path';



    public function handle(){
        $this->makeTransformer();
    }


    protected function makeTransformer(){
        $name = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath('Application\\Transformers\\'.$this->getNameInput().'Transformers');
        $this->line('Done create Api Class  at Application Transformers for api  '.$this->getNameInput() .'Transformers .');
        $this->files->put($path, $this->buildTransformers($name));
    }

    protected function getStub()
    {
        return __DIR__.'/stub/api/transformer.stub';
    }


    protected function buildTransformers($name){
        $stub = $this->files->get($this->getStub());
        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }


}
