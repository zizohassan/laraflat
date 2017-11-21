<?php

namespace App\Console\Commands;


use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;


class MakeDataTable extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:datatable';

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
                    $i=0;
                    foreach($col as $key => $c){
                        if($key == 0){
                            $this->colsArray[$i][] = $c;
                        }elseif($key == 1){
                            $this->colsArray[$i][]= $c;
                        }elseif($key == 2){
                            $this->colsArray[$i][]= $c;
                        }elseif($key == 3){
                            $this->colsArray[$i][]= $c;
                        }
                    }
                    $i++;

                }
            }
        }
        $this->createDataTable();
    }


    protected function createDataTable()
    {
        $name = strtolower($this->getNameInput());
        $path = $this->getPath('Application\\DataTables\\' . $this->getNameInput() . 'sDataTable');
        $nameDatatable = $this->getNameInput() . 'sDataTable';
        $this->line('Done create Datatable class  at Application DataTables  ' . $this->getNameInput() . 'sDatatable .');
        $this->files->put($path, $this->buildDataTable($name, $nameDatatable, $this->getStub()));
    }

    protected function buildDataTable($name, $nameDatatable, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DummyDatatable', $nameDatatable)
            ->replace($stub, 'DummyModelSmall', strtolower($name))
            ->replace($stub, 'DummyDefaultCols', $this->getDefaultCols())
            ->replaceView($stub, 'DummyModel', ucfirst($name));
    }


    protected function getStub()
    {
        return __DIR__ . '/stub/datatable.stub';
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


    protected function replaceView(&$stub, $rep, $name)
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


    protected function getDefaultCols()
    {
        if (count($this->colsArray) > 0){
            if(isset($this->colsArray[0][0])){
                $multiLanguage = isset($this->colsArray[0][3]) && $this->colsArray[0][3] == 'true' ? 'trans("'.strtolower($this->getNameInput()).'.'.$this->colsArray[0][0].'")' : '"'.$this->colsArray[0][0].'"';
                return "\t\t\t"."[
                'name' => '".$this->colsArray[0][0]."',
                'data' => '".$this->colsArray[0][0]."',
                'title' => ".$multiLanguage.",
                ".$this->getLangValue()."
                ],";
            }
          }
        return "\t\t\t"."[
                'name' => 'name',
                'data' =>  'name',
                'title' =>  'name',
        ],";
    }

    protected function getLangValue(){
        if (count($this->colsArray) > 0) {
            if (isset($this->colsArray[0][0])) {
                if(isset($this->colsArray[0][3]) && $this->colsArray[0][3] == 'true'){
                    return   "'render' => 'function(){
                        return JSON.parse(this.".$this->colsArray[0][0].").'.getCurrentLang().';
                    }',";
                }
            }
        }
        return '';
    }
}
