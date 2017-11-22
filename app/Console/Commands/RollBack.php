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
        Command::where('name' , ucfirst($name))->delete();
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



    protected function replaceFromFile($key , $path)
    {
        $fc=file($path);
        $f=fopen($path,"w");
        foreach($fc as $line)
        {
            if (!strstr($line,$key)) //look for $key in each line
                fputs($f,$line); //place $line back in file
        }
        fclose($f);
    }
}
