<?php

namespace App\Console\Commands;


use Illuminate\Console\GeneratorCommand;

class MakeModel extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:laraflat_model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create model in application path';


    protected $type = "Model";

    public function handle(){
        $this->createModel();
    }


    protected function createModel  (){
        $name = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath('Application\\Model\\'.$this->getNameInput());
        $this->line('Done create Model  at Application Model  '.$this->getNameInput() .' .');
        $this->files->put($path, $this->buildClass($name));
    }


    protected function getStub()
    {
        return __DIR__.'/stub/model.stub';
    }

    protected function buildClass($name){
        $stub = $this->files->get($this->getStub());
        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

}
