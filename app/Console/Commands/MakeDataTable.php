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
    protected $firstElemnt = [];

    public function handle()
    {
        if ($this->option('cols')) {
            $cols = $this->option('cols');
            $cols = explode(',', $cols);
            if ($cols) {
                foreach ($cols as $col) {
                    $col = explode(':', $col);
                    foreach ($col as $key => $c) {
                        if ($key == 0) {
                            $value = $c;
                            $this->colsArray[$value][] = $c;
                        } elseif ($key == 1) {
                            $this->colsArray[$value][] = $c;
                        } elseif ($key == 2) {
                            $this->colsArray[$value][] = $c;
                        } elseif ($key == 3) {
                            $this->colsArray[$value][] = $c;
                        }
                    }
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
            ->replace($stub, 'DummyRequestFilter', $this->getFilters())
            ->replace($stub, 'DummyModelSmall', strtolower($name))
            ->replace($stub, 'DummyDefaultCols', $this->getDefaultCols())
            ->replaceView($stub, 'DummyModel', ucfirst($name));
    }


    protected function getFilters()
    {
        if (count($this->colsArray) > 0) {
            $out = '';
            foreach ($this->colsArray as $filter) {
                if(!in_array($filter[0] ,notFilter() )){
                    $f = str_contains($filter[0] , '[]') ? str_replace('[]' , '' , $filter[0]) : $filter[0];
                    $out .= "\t\t".'if(request()->has("' . $f . '") && request()->get("' . $f . '") != ""){'."\n";
                    if($filter[3] == 'true' || str_contains($filter[0] , '[]')){
                        $out .= "\t\t\t\t".'$query = $query->where("' . $f . '","like", "%".request()->get("' . $f . '")."%");'."\n";
                    }else{
                        $out .= "\t\t\t\t".'$query = $query->where("' . $f . '","=", request()->get("' . $f . '"));'."\n";
                    }
                    $out .= "\t\t".'}' . "\n\n";
                }
            }
            $this->firstElemnt = array_shift($this->colsArray);
            return $out;
        }
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
        if (count($this->firstElemnt) > 0) {
            if (isset($this->firstElemnt[0])) {
                $title = str_contains($this->firstElemnt[0] , '[]') ? str_replace('[]' , '' , $this->firstElemnt[0]) : $this->firstElemnt[0];
                $multiLanguage = isset($this->firstElemnt[3]) && $this->firstElemnt[3] == 'true' ? 'trans("' . strtolower($this->getNameInput()) . '.' .$title . '")' : '"' . $title . '"';
                return "\t\t\t" . "[
                'name' => '" . $title. "',
                'data' => '" . $title . "',
                'title' => " . $multiLanguage . ",
                " . $this->getLangValue() . "
                ],";
            }
        }
        return "\t\t\t" . "[
                'name' => 'name',
                'data' =>  'name',
                'title' =>  'name',
        ],";
    }

    protected function getLangValue()
    {
        if (count($this->firstElemnt) > 0) {
            if (isset($this->firstElemnt[0])) {
                if (isset($this->firstElemnt[3]) && $this->firstElemnt[3] == 'true') {
                    return "'render' => 'function(){
                        return JSON.parse(this." . $this->firstElemnt[0] . ").'.getCurrentLang().';
                    }',";
                }elseif (in_array($this->firstElemnt[0], getFileFieldsName())){
                    $title = str_contains($this->firstElemnt[0] , '[]') ? str_replace('[]' , '' , $this->firstElemnt[0]) : $this->firstElemnt[0];
                    if(in_array($this->firstElemnt[0], getImageFields())){
                        $url = url(env('SMALL_IMAGE_PATH')).'/';
                        if(str_contains($this->firstElemnt[0] , '[]')){
                            return "'render' => 'function( ){
                                       return \'<img src=\"".$url."\'+JSON.parse(this.".$title.")[0]+\'\" /> \';
                                    }',";
                        } else{
                            return "'render' => 'function( ){
                                       return \'<img src=\"".$url."\'+JSON.parse(this.".$title.")+\'\" /> \';
                                    }',";
                        }
                    }else{
                        $url = url(env('UPLOAD_PATH')).'/';
                        if(str_contains($this->firstElemnt[0] , '[]')){
                            return "'render' => 'function( ){
                                       return \'<a href=\"".$url."\'+JSON.parse(this.".$title.")[0]+\'\"><i class=\"fa fa-file\"></i></a> \';
                                    }',";

                        } else{
                            return "'render' => 'function( ){
                                       return \'<a href=\"".$url."\'+JSON.parse(this.".$title.")+\'\"><i class=\"fa fa-file\"></i></a> \';
                                    }',";
                        }
                    }
                }elseif (str_contains($this->firstElemnt[0] , '[]') && !in_array($this->firstElemnt[0], getFileFieldsName())){
                    $title = str_contains($this->firstElemnt[0] , '[]') ? str_replace('[]' , '' , $this->firstElemnt[0]) : $this->firstElemnt[0];
                    return "'render' => 'function(){
                       return JSON.parse(this." . $title . ");
                    }',";
                }
            }
        }
        return '';
    }

}
