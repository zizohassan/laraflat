<?php

namespace App\Console\Commands;


use App\Application\Model\Command;
use App\Application\Model\Item;
use App\Application\Model\Permission;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;


class RollBack extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:rollback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback Model .';

    public function handle(){
        $name = ucfirst($this->getNameInput());
        Permission::where('controller_name'  ,$name.'Controller')->delete();
        $this->deleteFile(app_path('Application/Controllers/Admin/'.$name.'Controller.php'));
        $this->deleteFile(app_path('Application/Controllers/Api/'.$name.'Api.php'));
        $this->deleteFile(app_path('Application/Controllers/Website/'.$name.'Controller.php'));
        $this->deleteFile(app_path('Application/DataTables/'.$name.'sDataTable.php'));
        $this->deleteFile(app_path('Application/Model/'.$name.'.php'));
        $this->deleteDir(app_path('Application/Requests/Admin/'.$name));
        $this->deleteDir(app_path('Application/Requests/Website/'.$name));
        $this->deleteFile(app_path('Application/Transformers/'.$name.'Transformers.php'));
        $this->deleteDir(app_path('Application/views/admin/'.strtolower($name)));
        $this->deleteDir(app_path('Application/views/website/'.strtolower($name)));
        $this->deleteFile(resource_path('lang/ar/'.strtolower($name).'.php'));
        $this->deleteFile(resource_path('lang/en/'.strtolower($name).'.php'));
        if(Item::where('link' , '/admin/'.strtolower($name))->count() > 0){
            Item::where('link' , '/admin/'.strtolower($name))->delete();
        }
        if(Item::where('link' , strtolower($name))->count() > 0){
            Item::where('link' , strtolower($name))->delete();
        }
        $dir = app_path('Application/routes/appendWebsite.php');
        $this->replaceFromFile($name.'Controller@' ,$dir );
        $this->replaceFromFile('#### '.strtolower($name).' control' ,$dir );
        $dir = app_path('Application/routes/appendApi.php');
        $this->replaceFromFile($name.'Api@' ,$dir );
        $this->replaceFromFile('#'.strtolower($name) ,$dir );
        $dir = app_path('Application/routes/admin.php');
        $this->replaceFromFile($name.'Controller@' ,$dir );
        $this->replaceFromFile('#### '.strtolower($name).' control' ,$dir );
        $migrationPath = database_path('migrations');
        foreach(scandir($migrationPath) as $file){
           $migration =  explode('_' , $file);
            if(isset($migration[4]) && isset($migration[5]) && isset($migration[6])){
                $migration_name = $migration[4].'_'.$migration[5].'_'.$migration[6];
                if($migration_name == 'create_'.strtolower($name).'_table.php'){
                   $this->deleteFile(database_path('migrations/'.$file));
                }
            }
        }
        shell_exec('composer --working-dir='.app_path("/").' dumpautoload');
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists(strtolower($name));
        Schema::enableForeignKeyConstraints();
        $commands = Command::where('name' , ucfirst($name))->get();
        if(count($commands) > 0){
            $command = $commands[0];
            if($command->command == 'laraflat:comment'){
                $this->rolBackComment($command);
            }
        }
        Command::where('name' , ucfirst($name))->delete();
    }

    public function rolBackComment($command){
        $this->deleteFile(app_path('Application/views/admin/'.$command->options.'/comment/edit.blade.php'));
        $this->deleteFile(app_path('Application/views/admin/'.$command->options.'/comment/show.blade.php'));
        $this->deleteFile(app_path('Application/views/website/'.$command->options.'/comment/edit.blade.php'));
        $this->deleteFile(app_path('Application/views/website/'.$command->options.'/comment/show.blade.php'));
        $this->deleteFile(app_path('Application/Controllers/Admin/'.$command->name.'Controller.php'));
        $this->deleteFile(app_path('Application/Controllers/Website/'.$command->name.'Controller.php'));
        $this->replaceLines("public function ".strtolower($command->name)."(){", app_path('Application/Model/' . ucfirst($command->options) . '.php'));
        $this->replaceFromFile('@include("admin.' . $command->options . '.comment.edit")', app_path('Application/views/admin/'.$command->options.'/edit.blade.php'));
        $this->replaceFromFile('@include("admin.' . $command->options . '.comment.show")' , app_path('Application/views/admin/'.$command->options.'/show.blade.php'));
        $this->replaceFromFile('@include("website.' . $command->options . '.comment.edit")', app_path('Application/views/website/'.$command->options.'/edit.blade.php'));
        $this->replaceFromFile('@include("website.' .$command->options . '.comment.show")', app_path('Application/views/website/'.$command->options.'/show.blade.php'));
        $this->replaceFromFile('@include("admin.' . $command->options . '.comment.edit")', app_path('Application/views/admin/'.$command->options.'/show.blade.php'));
        $this->replaceFromFile('@include("website.' .$command->options . '.comment.edit")', app_path('Application/views/website/'.$command->options.'/show.blade.php'));
        $this->replaceFromFile('@include("admin.' . $command->options . '.comment.show")', app_path('Application/views/admin/'.$command->options.'/show.blade.php'));
        $this->replaceFromFile('@include("website.' .$command->options . '.comment.show")', app_path('Application/views/website/'.$command->options.'/show.blade.php'));

        $dir = app_path('Application/routes/appendWebsite.php');
        $this->replaceFromFile(ucfirst($command->name).'Controller@addComment' ,$dir );
        $this->replaceFromFile(ucfirst($command->name).'Controller@updateComment' ,$dir );
        $this->replaceFromFile('#### '.strtolower($command->name) ,$dir );
        $dir = app_path('Application/routes/admin.php');
        $this->replaceFromFile(ucfirst($command->name).'Controller@addComment' ,$dir );
        $this->replaceFromFile(ucfirst($command->name).'Controller@updateComment' ,$dir );
        $this->replaceFromFile('#### '.strtolower($command->name).' comment' ,$dir );

        Permission::where('name' , 'comment-'.$command->name)->delete();

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
    protected function deleteFile($fileName){
        if(file_exists($fileName)){
            File::delete($fileName);
        }
    }

    public  function deleteDir($dirPath) {
        if(file_exists($dirPath)){
            if (! is_dir($dirPath)) {
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


}
