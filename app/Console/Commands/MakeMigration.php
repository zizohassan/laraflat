<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputArgument;


class MakeMigration extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:migrate';

    protected $colsMigration = [];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create  Migration';

    public function handle(){
        if($this->option('cols')){
            $this->setCols();
        }
        $this->makeMigration();
        shell_exec('composer --working-dir='.app_path("/").' dumpautoload');
//        Artisan::call('dump-autoload');
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
                    $this->colsMigration[$name] = $c;
                }
            }
        }
    }

    protected function makeMigration()
    {
        $name = ucfirst($this->getNameInput());
        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.'/stub/migration.stub';
        $this->line('Done create Migration class  '.$this->getNameInput());
        $path = base_path('database'.$DS.'migrations'.$DS.date('Y_m_d').'_'.time().'_create_'.strtolower($this->getNameInput()).'_table.php');
        $this->files->put($path, $this->buildRequest( $name   , $file));
    }



    protected function buildRequest($name   , $stub ){
        $stub = $this->files->get($stub);
        return $this->replace( $stub, 'DummyTable',strtolower($name))
            ->replace($stub , 'DummyFields', $this->reFormatRequest())
            ->replaceView( $stub, 'DummyName','Create'.ucfirst($name).'Table');
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
            ['cols', 'c', InputArgument::OPTIONAL, 'Generate request columns']
        ];
    }

    protected function getStub()
    {

    }

    protected function reFormatRequest(){
        $array = getMigrationType();
        $reuslt = '';
        foreach($this->colsMigration as $key => $value){
            $nullable = in_array($value  , $array) ? "->nullable()" : '';
            if(str_contains( $key , '[]')){
                $key = str_replace('[]' ,'', $key);
                $value = 'text';
            }
            $reuslt .= '$table->'.$value.'("'.$key.'")'.$nullable.';'."\n\t\t\t";
        }
        return $reuslt;
    }

}
