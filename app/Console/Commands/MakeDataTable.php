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
                    $out .= "\t\t".'if(request()->has("' . $filter[0] . '") && request()->get("' . $filter[0] . '") != ""){'."\n";
                    if($filter[3] == 'true'){
                        $out .= "\t\t\t\t".'$query = $query->where("' . $filter[0] . '","like", "%".request()->get("' . $filter[0] . '")."%");'."\n";
                    }else{
                        $out .= "\t\t\t\t".'$query = $query->where("' . $filter[0] . '","=", request()->get("' . $filter[0] . '"));'."\n";
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
                $multiLanguage = isset($this->firstElemnt[3]) && $this->firstElemnt[3] == 'true' ? 'trans("' . strtolower($this->getNameInput()) . '.' . $this->firstElemnt[0] . '")' : '"' . $this->firstElemnt[0] . '"';
                return "\t\t\t" . "[
                'name' => '" . $this->firstElemnt[0] . "',
                'data' => '" . $this->firstElemnt[0] . "',
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
                }
            }
        }
        return '';
    }
}
