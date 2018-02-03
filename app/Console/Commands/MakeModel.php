<?php

namespace App\Console\Commands;


use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;


class MakeModel extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create model in application path';


    protected $type = "Model";

    protected $colsArray = [];
    protected $colsType = [];
    protected $colsValidation = [];
    protected $multiLanguage = [];

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
        }
        $this->createModel();
        if(count($this->colsValidation) > 0 ){
            $this->call('laraflat:request' , ['name' => class_basename($this->getNameInput()) , '--cols' => $this->fillValidation()]);
            $this->call('laraflat:admin_request' , ['name' => class_basename($this->getNameInput()) , '--cols' => $this->fillValidation()]);
        }else{
            $this->call('laraflat:request' , ['name' => class_basename($this->getNameInput())]);
            $this->call('laraflat:admin_request' , ['name' => class_basename($this->getNameInput())]);
        }
        if(count($this->colsType) > 0 ){
            $this->call('laraflat:migrate' , ['name' => class_basename($this->getNameInput()) , '--cols' => $this->filltype()]);
        }else{
            $this->call('laraflat:migrate' , ['name' => class_basename($this->getNameInput())]);
        }
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
        return $this->replace( $stub, 'DummyTable',strtolower(class_basename($name)))
                    ->replace( $stub, 'DummyFillAbel',$this->appdenToFillable())
                    ->replace( $stub, 'DummyMultiFiles',$this->putMultiLangFields())
                    ->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }


    protected function putMultiLangFields(){
        $out = '';
        if(count($this->multiLanguage) > 0){
            foreach ($this->multiLanguage as $key => $lang){
                if($lang === "true"){
                    $out .= "\t".'public function get'.ucfirst($key).'LangAttribute(){'."\n";
                    $out .= "\t\t".'return is_json($this->'.$key.') && is_object(json_decode($this->'.$key.')) ?  json_decode($this->'.$key.')->{getCurrentLang()}  : $this->'.$key.';'."\n";
                    $out .= "\t".'}'."\n";
                    foreach (getAvLang() as $k => $L){
                        $out .= "\t".'public function get'.ucfirst($key).ucfirst($k).'Attribute(){'."\n";
                        $out .= "\t\t".'return is_json($this->'.$key.') && is_object(json_decode($this->'.$key.')) ?  json_decode($this->'.$key.')->'.$k.'  : $this->'.$key.';'."\n";
                        $out .= "\t".'}'."\n";
                    
                    }
                }
            }
        }
        return  $out ;
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

    protected function getOptions()
    {
        return [
            ['cols', 'c', InputArgument::OPTIONAL, 'Set Model Fillable , request , migration columns']
        ];
    }

     protected function appdenToFillable()
    {
        if(count($this->colsArray) > 0){
            $out =  "'".implode("','" , array_keys($this->colsArray))."'";
            if(str_contains($out , '[]')){
                $out = str_replace('[]' ,'' , $out);
            }
            return $out;
        }
        return ' ';
    }

    protected function fillValidation(){
        $result = '';
        $i = 0;
        foreach($this->colsValidation as $key => $value){
            $multiLanguage = isset($this->multiLanguage[$key]) && $this->multiLanguage[$key] == 'true' ? '.*' : '';
            $i++;
            $result .= $key.$multiLanguage.':'.str_replace('|' , '_' ,str_replace(':' , '-' , $value));
            $result .= count($this->colsValidation)  != $i ? ',':'';
        }
        return $result;
    }

    protected function filltype(){
        $result = '';
        $i = 0;
        foreach($this->colsType as $key => $value){
            $result .= $key.':'.$value;
            $result .=count($this->colsType)  != $i ? ',':'';
            $i++;
        }
        return $result;
    }
}

