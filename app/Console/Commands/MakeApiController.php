<?php

namespace App\Console\Commands;


use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakeApiController extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:api_controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Api Controller in application path';



    public function handle(){
        if($this->option('cols')){
            $cols = $this->option('cols');
            $cols = explode(',' , $cols);
            if($cols){
                foreach($cols as $col){
                    $col = explode(':' , $col);
                    foreach($col as $key => $c){
                        if($key == 0){
                            $this->colsArray[$c] = $c;
                            $name = $c;
                        }elseif($key == 1){
                            $this->colsType[$name] = $c;
                        }elseif($key == 2){
                            $this->colsValidation[$name] = str_replace('_' , '|' , str_replace('-' , ':' , $c));
                        }elseif($key == 3){
                            $this->multiLanguage[$name] = $c;
                        }
                    }
                }
            }
            $this->call('laraflat:api_request' , ['name' => class_basename($this->getNameInput()) , '--cols' => $this->fillValidation()]);
            $this->call('laraflat:transformer' , ['name' => class_basename($this->getNameInput()) ,'--cols' => $this->option('cols')]);
            if(!file_exists(app_path('Application/Model/'.ucfirst($this->getNameInput())).'.php')) {
                $this->call('laraflat:model', ['name' => class_basename($this->getNameInput()), '--cols' => $this->option('cols')]);
            }
        }else{
            $this->call('laraflat:api_request' , ['name' => class_basename($this->getNameInput())]);
            if(!file_exists(app_path('Application/Model/'.ucfirst($this->getNameInput())).'.php')) {
                $this->call('laraflat:model', ['name' => class_basename($this->getNameInput())]);
            }
        }
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

    protected function getOptions()
    {
        return [
            ['cols', 'c', InputArgument::OPTIONAL, 'Set Model Fillable , request , migration columns']
        ];
    }

    protected function fillValidation(){
        $result = '';
        $i = 1;
        foreach($this->colsValidation as $key => $value){
            $multiLanguage = isset($this->multiLanguage[$key]) && $this->multiLanguage[$key] == 'true' ? '.*' : '';
            $i++;
            $result .= $key.$multiLanguage.':'.str_replace('|' , '_' ,str_replace(':' , '-' , $value));
            $result .= count($this->colsValidation)  == $i ? ',':'';
        }
        return $result;
    }

}
