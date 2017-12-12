<?php

namespace App\Console\Commands;

use App\Console\Commands\Helpers\RequestTrait;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputArgument;


class MakeAdminRequest extends GeneratorCommand
{

    use RequestTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:admin_request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create Admin Request in application path';

    protected $colsValidation = [];

    public function handle(){
        if($this->option('cols')){
            $this->setCols();
        }
        $this->makeRequest();
        $this->makeRequest('UpdateRequest');
    }

    protected function setCols(){
        $cols = $this->option('cols');
        $cols = explode(',' , $cols);
        foreach($cols as $col){
            $col = explode(':' , $col);
            foreach($col as $key => $c){
                if($key == 0){
                    $name = $c;
                }elseif($key == 1){
                    $this->colsValidation[$name] = str_replace('_' , '|' , str_replace('-' , ':' , $c));
                }
            }
        }
    }

    protected function makeRequest($requestType = 'AddRequest')
    {
        $ds = DIRECTORY_SEPARATOR;
        $name = ucfirst($this->getNameInput());
        $folderName = ucfirst($this->getNameInput());
        $pathFile = app_path('Application'.$ds.'Requests'.$ds.'Admin'.$ds.$folderName);
        if(!file_exists($pathFile)){
            File::makeDirectory($pathFile, 0775, true);
        }
        if($requestType == 'AddRequest'){
            $file =   __DIR__.'/stub/addrequest.stub';
        }else{
            $file =   __DIR__.'/stub/updaterequest.stub';
        }
        $path = $this->getPath('Application\\Requests\\Admin\\'.$folderName.'\\'.$requestType.$name);
        $this->line('Done create Request class  at Application   '.$requestType.$this->getNameInput());
        $this->files->put($path, $this->buildRequest( $name ,  'Admin\\'.$folderName  , $file));
    }

    protected function buildRequest($name  , $nameDatatable  , $stub ){
        $stub = $this->files->get($stub);
        return $this->replace( $stub, 'DummyFolder',$nameDatatable)
            ->replace($stub , 'DummyValidation', $this->reFormatRequest())
            ->replaceView( $stub, 'DummyName',ucfirst($name));
    }

    protected function getStub()
    {

    }

    protected function getOptions()
    {
        return [
            ['cols', 'c', InputArgument::OPTIONAL, 'Generate request columns']
        ];
    }


}
