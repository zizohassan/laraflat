<?php

namespace App\Console\Commands;

use App\Console\Commands\Helpers\RequestTrait;
use function GuzzleHttp\Psr7\str;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputArgument;


class ApiRequest extends GeneratorCommand
{

    use RequestTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:api_request';

    protected $colsValidation = [];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create  Request in application path';

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
        $pathFile = app_path('Application'.$ds.'Requests'.$ds.'Website'.$ds.$folderName);
        if(!file_exists($pathFile)){
            File::makeDirectory($pathFile, 0775, true);
        }
        if($requestType == 'AddRequest'){
            $apiFile =  __DIR__.'/stub/apiaddrequest.stub';
        }else{
            $apiFile =  __DIR__.'/stub/apiupdaterequest.stub';
        }
        $apiPath = $this->getPath('Application\\Requests\\Website\\'.$folderName.'\\Api'.$requestType.$name);
        $this->line('Done create Request class  at Application Api'.$requestType.$this->getNameInput());
        $this->files->put($apiPath, $this->buildRequest( $name ,  'Website\\'.$folderName  , $apiFile));
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

    protected function reFormatRequest()
    {
        if ($this->colsValidation) {
            $result = '';
            $images = [];

            foreach ($this->colsValidation as $key => $cols) {
                $key = str_replace('.*' , '' , $key);
                if (in_array($key, getImageFields())) {
                    $cols = str_replace(['|nullable', '|required'], '', $cols);
                    $getDimensions = explode(':', $cols);
                    if(isset($getDimensions[1])){
                        $images[$getDimensions[1]] = $key;
                    }else{
                        $images[env('SMALL_IAMGE_WIDTH').'X'.env('SMALL_IAMGE_HEIGHT')] = $key;
                    }
                    if (str_contains($key, '[]')) {
                        $key = str_replace('[]', '', $key).'.*';
                    }
                    $result .= '"' . $key . '" => "' . $getDimensions[0] . '",' . "\n\t\t\t";
                } else {
                    if (str_contains($key, '[]')) {
                        $key = str_replace('[]', '', $key).'.*';
                    }
                    $result .= '"' . $key . '" => "' . $cols . '",' . "\n\t\t\t";
                }
            }
            $this->createConfigFile($images);
            return $result;
        }
        return ' ';
    }

    protected function getOptions()
    {
        return [
            ['cols', 'c', InputArgument::OPTIONAL, 'Generate request columns']
        ];
    }

}
