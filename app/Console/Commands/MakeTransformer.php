<?php

namespace App\Console\Commands;


use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;


class MakeTransformer extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:transformer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create  Transformer in application path';


    protected $colsArray = [];

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
                        }elseif($key == 3){
                            $this->colsArray[$name]= $c;
                        }
                    }
                }
            }
        }
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
        $ar = $this->getData();
        $en = $this->getData('en');
        $stub = $this->files->get($this->getStub());
        return $this->replace( $stub, 'DummyAr',$ar )
            ->replace( $stub, 'DummyEn',$en)->replaceNamespace($stub, $name)->replaceClass($stub, $name);
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

    protected function getData($lang = 'ar'){
        if($this->option('cols')){
            return $this->data($lang);
        }else{
            return $this->defaultData($lang);
        }
    }

    protected function data($lang = 'ar'){
        $result = '';
        $i = 1;
        $result .='"id" => $modelOrCollection->id,'."\n";
        foreach($this->colsArray as $key => $value){
            $multiLanguage =  $value == 'true' ? true : false;
            $i++;
            if(!$multiLanguage){
                $result .= "\t\t\t".'"'.$key.'" => $modelOrCollection->'.$key;
            }else{
                $result .= "\t\t\t".'"'.$key.'" => $modelOrCollection->{lang("'.$key.'" , "'.$lang.'")}';
            }
            $result .= count($this->colsArray)  == $i ? ',':',';
            $result .= "\n";
        }
        return $result;
    }

    protected function getOptions()
    {
        return [
            ['cols', 'c', InputArgument::OPTIONAL, 'Set Model Fillable , request , migration columns']
        ];
    }

    protected function defaultData($lang = 'ar'){
        return
            '"id" => $modelOrCollection->id,
            "name" =>  $modelOrCollection->{lang("name" , "'.$lang.'")},
            "image" => url(env("UPLOAD_PATH")."/".$modelOrCollection->image),';
    }


}
