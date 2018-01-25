<?php

namespace App\Console\Commands;


use App\Application\Model\Command;
use App\Application\Model\Item;
use App\Application\Model\Permission;
use App\Application\Model\Relation;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;


class RelationRollBack extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:relation_rollBack';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback Model .';

    protected $pKey = null;
    protected $fKey = null;
    protected $type = null;
    protected $fk = 'true';
    protected $pluckFone = null;
    protected $pluckFtwo = null;
    protected $pluckPOne = null;
    protected $typeMtm = "checkbox";


    public function handle()
    {
        $this->setCols();


        $name = ucfirst($this->getNameInput());

//        $this->deleteFile(app_path('Application/Controllers/Admin/'.$name.'Controller.php'));
//        $this->deleteDir(app_path('Application/Requests/Admin/'.$name));

        $this->deleteDir(app_path('Application/views/admin/' . $this->pKey . '/relation/' . $this->fKey));
        $this->deleteDir(app_path('Application/views/admin/' . $this->fKey . '/relation/' . $this->pKey));
        $this->deleteDir(app_path('Application/views/website/' . $this->pKey . '/relation/' . $this->fKey));
        $this->deleteDir(app_path('Application/views/website/' . $this->fKey . '/relation/' . $this->pKey));

        $this->replaceFromFile('@include("admin.' . $this->fKey . '.relation.' . $this->pKey . '.edit")', app_path('Application/views/admin/' . $this->fKey . '/edit.blade.php'));
        $this->replaceFromFile('@include("admin.' . $this->pKey . '.relation.' . $this->fKey . '.edit")', app_path('Application/views/admin/' . $this->pKey . '/edit.blade.php'));
        $this->replaceFromFile('@include("admin.' . $this->fKey . '.relation.' . $this->pKey . '.show")', app_path('Application/views/admin/' . $this->fKey . '/show.blade.php'));
        $this->replaceFromFile('@include("admin.' . $this->pKey . '.relation.' . $this->fKey . '.show")', app_path('Application/views/admin/' . $this->pKey . '/show.blade.php'));

        $this->replaceFromFile('@include("website.' . $this->fKey . '.relation.' . $this->pKey . '.edit")', app_path('Application/views/website/' . $this->fKey . '/edit.blade.php'));
        $this->replaceFromFile('@include("website.' . $this->pKey . '.relation.' . $this->fKey . '.edit")', app_path('Application/views/website/' . $this->pKey . '/edit.blade.php'));
        $this->replaceFromFile('@include("website.' . $this->fKey . '.relation.' . $this->pKey . '.show")', app_path('Application/views/website/' . $this->fKey . '/show.blade.php'));
        $this->replaceFromFile('@include("website.' . $this->pKey . '.relation.' . $this->fKey . '.show")', app_path('Application/views/website/' . $this->pKey . '/show.blade.php'));


        $this->replaceLines("public function $this->pKey(){", app_path('Application/Model/' . ucfirst($this->fKey) . '.php'));
        $this->replaceLines("public function $this->fKey(){", app_path('Application/Model/' . ucfirst($this->pKey) . '.php'));


        $this->replaceLines('if(count($request->' . $this->pKey . '_id) > 0){', app_path('Application/Controllers/Admin/' . ucfirst($this->fKey) . 'Controller.php'));
        $this->replaceLines('if(count($request->' . $this->pKey . '_id) > 0){', app_path('Application/Controllers/Website/' . ucfirst($this->fKey) . 'Controller.php'));


        if ($this->type == 'oto' || $this->type == 'otm') {
            $this->replaceFromFile($this->pKey . '_id', app_path('Application/Requests/Admin/' . ucfirst($this->fKey) . '/AddRequest' . ucfirst($this->fKey) . '.php'));
            $this->replaceFromFile($this->pKey . '_id', app_path('Application/Requests/Admin/' . ucfirst($this->fKey) . '/UpdateRequest' . ucfirst($this->fKey) . '.php'));
            $this->replaceFromFile($this->pKey . '_id', app_path('Application/Requests/Website/' . ucfirst($this->fKey) . '/AddRequest' . ucfirst($this->fKey) . '.php'));
            $this->replaceFromFile($this->pKey . '_id', app_path('Application/Requests/Website/' . ucfirst($this->fKey) . '/UpdateRequest' . ucfirst($this->fKey) . '.php'));
            $this->replaceFromFile($this->pKey . '_id', app_path('Application/Requests/Website/' . ucfirst($this->fKey) . '/ApiAddRequest' . ucfirst($this->fKey) . '.php'));
            $this->replaceFromFile($this->pKey . '_id', app_path('Application/Requests/Website/' . ucfirst($this->fKey) . '/ApiUpdateRequest' . ucfirst($this->fKey) . '.php'));
            $this->replaceFromFile($this->pKey . '_id', app_path('Application/Model/' . ucfirst($this->fKey) . '.php'));
            $pk = $this->pKey;
            $ft = $this->fKey;
            if (Schema::hasColumn($this->fKey, $this->pKey . '_id')) {
                $arrayOfKeys = $this->listTableForeignKeys($this->fKey);
                Schema::table($this->fKey, function ($table) use ($pk , $ft, $arrayOfKeys) {
                    Schema::disableForeignKeyConstraints();
                    if(in_array($ft.'_'.$pk.'_id_foreign' , $arrayOfKeys)){
                        $table->dropForeign($ft.'_'.$pk . '_id_foreign');
                        $table->dropColumn($pk . '_id');
                    }else{
                        $table->dropColumn($pk . '_id');
                    }
                    Schema::enableForeignKeyConstraints();
                });
            }
        }


        $migrationPath = database_path('migrations');
        foreach(scandir($migrationPath) as $file){
            $migration =  explode('_' , $file);
            if(isset($migration[4]) && isset($migration[5]) && isset($migration[6])&& isset($migration[7])){
                $migration_name = $migration[4].'_'.$migration[5].'_'.$migration[6].'_table.php';
                if($migration_name == 'create_'.strtolower($name).'_table.php'){
                    $this->deleteFile(database_path('migrations/'.$file));
                }
            }
        }
        shell_exec('composer --working-dir='.app_path("/").' dumpautoload');

        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists(strtolower($this->pKey . '_' . $this->fKey));
        Schema::enableForeignKeyConstraints();
        Relation::where('name', $this->pKey . '_' . $this->fKey)->delete();
    }

    protected function setCols()
    {
        $cols = $this->option('options');
        $cols = explode(',', $cols);
        foreach ($cols as $key => $col) {
            if ($key == 0) {
                $this->pKey = $col;
            } elseif ($key == 1) {
                $this->fKey = $col;
            } elseif ($key == 2) {
                $this->type = $col;
            } elseif ($key == 3) {
                $this->fk = $col;
            } elseif ($key == 4) {
                $this->pluckFone = $col;
            } elseif ($key == 5) {
                $this->pluckFtwo = $col;
            } elseif ($key == 6) {
                $this->pluckPOne = $col;
            } elseif ($key == 7) {
                $this->typeMtm = $col;
            }
        }

    }

    protected function deleteFile($fileName)
    {
        if (file_exists($fileName)) {
            File::delete($fileName);
        }
    }

    public function deleteDir($dirPath)
    {
        if (file_exists($dirPath)) {
            if (!is_dir($dirPath)) {
                throw new InvalidArgumentException("$dirPath must be a directory");
            }
            if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
                $dirPath .= '/';
            }
            $files = glob($dirPath . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    self::deleteDir($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($dirPath);
        }
    }

    protected function getStub()
    {

    }


    protected function replaceFromFile($key, $path)
    {
        try{
            if(file_exists($path)){
                $fc = file($path);
                $f = fopen($path, "w");
                foreach ($fc as $line) {
                    if (!strstr($line, $key)) //look for $key in each line
                        fputs($f, $line); //place $line back in file
                }
                fclose($f);
            }
        }catch(\Expection $e){

        }
    }

    protected function replaceLines($key, $path, $linesNUmber = 3)
    {
        try{
            if(file_exists($path)) {
                $fc = file($path);
                $f = fopen($path, "w");
                $i = 0;
                foreach ($fc as $line) {
                    if ($i == 0) {
                        if (strstr($line, $key)) {
                            $i++;
                        } else {
                            fputs($f, $line);
                        }
                    } elseif ($i == $linesNUmber - 1) {
                        $i = 0;
                    } elseif ($i < $linesNUmber) {
                        $i++;
                    } else {
                        fputs($f, $line);
                    }
                }
                fclose($f);
            }
        }catch(\Expection $e){

        }
    }

    protected function getOptions()
    {
        return [
            ['options', 'c', InputArgument::OPTIONAL, 'Generate request columns']
        ];
    }

    public function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();
        return array_map(function($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }

}
