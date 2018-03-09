<?php

namespace App\Console\Commands;


use App\Application\Model\Command;
use App\Application\Model\Item;
use App\Application\Model\Permission;
use App\Application\Model\Relation;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
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

    public function handle()
    {
        $name = ucfirst($this->getNameInput());

        Permission::where('controller_name', $name . 'Controller')->delete();

        $this->deleteFile(app_path('Application/Controllers/Admin/' . $name . 'Controller.php'));
        $this->deleteFile(app_path('Application/Controllers/Admin/' . $name . 'CommentController.php'));
        $this->deleteFile(app_path('Application/Controllers/Website/' . $name . 'CommentController.php'));
        $this->deleteFile(app_path('Application/Controllers/Website/' . $name . 'RateController.php'));
        $this->deleteFile(app_path('Application/Controllers/Admin/' . $name . 'RateController.php'));
        $this->deleteFile(app_path('Application/Model/' . $name . 'Rate.php'));
        $this->deleteFile(app_path('Application/Model/' . $name . 'Comment.php'));
        $this->deleteDir(app_path('Application/Requests/Admin/' . $name.'Comment'));
        $this->deleteDir(app_path('Application/Requests/Admin/' . $name.'Rate'));
        $this->deleteDir(app_path('Application/Requests/Website/' . $name.'Comment'));
        $this->deleteDir(app_path('Application/Requests/Website/' . $name.'Rate'));
        $this->deleteFile(app_path('Application/routes/'.mb_strtolower($name).'.php'));
        $this->deleteFile(app_path('Application/routes/'.mb_strtolower($name).'api.php'));
        $this->deleteFile(app_path('Application/Controllers/Api/' . $name . 'Api.php'));
        $this->deleteFile(app_path('Application/Controllers/Website/' . $name . 'Controller.php'));
        $this->deleteFile(app_path('Application/DataTables/' . $name . 'sDataTable.php'));
        $this->deleteFile(app_path('Application/Model/' . $name . '.php'));
        $this->deleteDir(app_path('Application/Requests/Admin/' . $name));
        $this->deleteDir(app_path('Application/Requests/Website/' . $name));
        $this->deleteFile(app_path('Application/Transformers/' . $name . 'Transformers.php'));
        $this->deleteDir(app_path('Application/views/admin/' . strtolower($name)));
        $this->deleteDir(app_path('Application/views/website/' . strtolower($name)));
        $this->deleteFile(resource_path('lang/ar/' . strtolower($name) . '.php'));
        $this->deleteFile(resource_path('lang/en/' . strtolower($name) . '.php'));
        $this->deleteFile(resource_path('lang/en/' . strtolower($name) . '.php'));
        $this->deleteFile(base_path('config/' . strtolower($name) . '.php'));
        $this->deleteFile(app_path('Application/views/website/sidebar/' . strtolower($name) . '.blade.php'));
        $this->deleteFile(app_path('Application/views/website/homepage/' . strtolower($name) . '.blade.php'));
        $this->deleteFile(base_path('config/'.mb_strtolower($name).'.php'));
        if (Item::where('link', '/admin/' . strtolower($name))->count() > 0) {
            Item::where('link', '/admin/' . strtolower($name))->delete();
        }
        if (Item::where('link', strtolower($name))->count() > 0) {
            Item::where('link', strtolower($name))->delete();
        }
        $dir = app_path('Application/routes/appendWebsite.php');
        $this->replaceFromFile($name . 'Controller@', $dir);
        $this->replaceFromFile("require_once __DIR__ . '/".mb_strtolower($name).".php';", $dir);
        $this->replaceFromFile('#### ' . strtolower($name) . ' control', $dir);
        $dir = app_path('Application/routes/appendApi.php');
        $this->replaceFromFile($name . 'Api@', $dir);
        $this->replaceFromFile("require_once __DIR__ . '/".mb_strtolower($name)."api.php';", $dir);
        $this->replaceFromFile('#' . strtolower($name), $dir);
        $dir = app_path('Application/routes/admin.php');
        $this->replaceFromFile($name . 'Controller@', $dir);
        $this->replaceFromFile("require_once __DIR__ . '/".mb_strtolower($name).".php';", $dir);
        $this->replaceFromFile('#### ' . strtolower($name) . ' control', $dir);
        $migrationPath = database_path('migrations');
        foreach (scandir($migrationPath) as $file) {
            $migration = explode('_', $file);
            if (isset($migration[4]) && isset($migration[5]) && isset($migration[6])) {
                $migration_name = $migration[4] . '_' . $migration[5] . '_' . $migration[6];
                if ($migration_name == 'create_' . strtolower($name) . '_table.php') {
                    DB::table('migrations')->where('migration' , explode('.' , $file)[0])->delete();
                    $this->deleteFile(database_path('migrations/' . $file));
                }
                if ($migration_name == 'create_' . strtolower($name).'comment' . '_table.php') {
                    DB::table('migrations')->where('migration' , explode('.' , $file)[0])->delete();
                    $this->deleteFile(database_path('migrations/' . $file));
                }
                if ($migration_name == 'create_' . strtolower($name).'rate' . '_table.php') {
                    DB::table('migrations')->where('migration' , explode('.' , $file)[0])->delete();
                    $this->deleteFile(database_path('migrations/' . $file));
                }
            }
        }


        $relation = Relation::where('f', strtolower($name))->get();
        if (count($relation) > 0) {
            foreach ($relation as $rel) {
                foreach (scandir($migrationPath) as $file) {
                    $migration = explode('_', $file);
                    if (isset($migration[4]) && isset($migration[5]) && isset($migration[6]) && isset($migration[7])) {
                        $migration_name = $migration[4] . '_' . $migration[5] . '_' . $migration[6] . '_table.php';
                        if ($migration_name == 'create_' . $rel->name . '_table.php') {
                            DB::table('migrations')->where('migration' , explode('.' , $file)[0])->delete();
                            $this->deleteFile(database_path('migrations/' . $file));
                        }
                    }
                }
            }
        }

        $relation = Relation::where('p' , strtolower($name))->get();
        if (count($relation) > 0) {
            foreach ($relation as $rel) {
                foreach (scandir($migrationPath) as $file) {
                    $migration = explode('_', $file);
                    if (isset($migration[4]) && isset($migration[5]) && isset($migration[6]) && isset($migration[7])) {
                        $migration_name = $migration[4] . '_' . $migration[5] . '_' . $migration[6] . '_table.php';
                        if ($migration_name == 'create_' . $rel->name . '_table.php') {
                            DB::table('migrations')->where('migration' , explode('.' , $file)[0])->delete();
                            $this->deleteFile(database_path('migrations/' . $file));
                        }
                    }
                }
            }
        }

        shell_exec('composer --working-dir=' . app_path("/") . ' dumpautoload');
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists(strtolower($name));
        Schema::enableForeignKeyConstraints();
        $command = Command::where('name', ucfirst($name))->first();
        if ($command) {
            if ($command->command == 'laraflat:comment') {
                $this->rolBackComment($command);
            }
            if ($command->command == 'laraflat:rate') {
                $this->rolBackRate($command);
            }
        }
        $commands = Command::where('options', mb_strtolower($name))->get();
        if(count($commands) > 0 ){
            foreach ( $commands as $c){
                if ($c->command == 'laraflat:comment') {
                    $this->rolBackComment($c);
                }
                if ($c->command == 'laraflat:rate') {
                    $this->rolBackRate($c);
                }
            }
        }

        $rel = Relation::where('f' , mb_strtolower($name))->get();

        if(count($rel) > 0){
            foreach ($rel as $r){
                Artisan::call('laraflat:relation_rollBack', ['name' => $r->name, '--options' => $r->options]);
            }
        }

        $rel = Relation::where('p' , mb_strtolower($name))->get();
        if(count($rel) > 0){
            foreach ($rel as $r){
                Artisan::call('laraflat:relation_rollBack', ['name' => $r->name, '--options' => $r->options]);
            }
        }
        Command::where('name' ,$name.'Comment')->delete();
        Command::where('name' ,$name.'Rate')->delete();
        Command::where('name', ucfirst($name))->delete();
        Relation::where('f' , mb_strtolower($name))->delete();
        Relation::where('p' , mb_strtolower($name))->delete();
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
        $this->replaceFromFile(ucfirst($command->name).'Controller@deleteComment' ,$dir );
        $this->replaceFromFile('#### '.strtolower($command->options) ,$dir );
        $dir = app_path('Application/routes/admin.php');
        $this->replaceFromFile(ucfirst($command->name).'Controller@addComment' ,$dir );
        $this->replaceFromFile(ucfirst($command->name).'Controller@updateComment' ,$dir );
        $this->replaceFromFile(ucfirst($command->name).'Controller@deleteComment' ,$dir );
        $this->replaceFromFile('#### '.strtolower($command->options).' comment' ,$dir );

        if(file_exists(app_path('Application/routes/'.mb_strtolower($command->options).'.php'))){
            $dir = app_path('Application/routes/'.mb_strtolower($command->options).'.php');
            $this->replaceFromFile(ucfirst($command->name).'Controller@addComment' ,$dir );
            $this->replaceFromFile(ucfirst($command->name).'Controller@updateComment' ,$dir );
            $this->replaceFromFile(ucfirst($command->name).'Controller@deleteComment' ,$dir );
            $this->replaceFromFile('#### '.strtolower($command->options).' comment' ,$dir );
        }

        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists(strtolower($command->options.'comment'));
        Schema::enableForeignKeyConstraints();

        $this->deleteFile(base_path('config/'.mb_strtolower($command->options).'scomment.php'));
        Permission::where('name' , 'comment-'.$command->name)->delete();

    }

    public function rolBackRate($command){
        $this->deleteFile(app_path('Application/views/admin/'.$command->options.'/rate/rate.blade.php'));
        $this->deleteFile(app_path('Application/views/admin/'.$command->options.'/rate/rate.blade.php'));
        $this->deleteFile(app_path('Application/views/website/'.$command->options.'/rate/rate.blade.php'));
        $this->deleteFile(app_path('Application/views/website/'.$command->options.'/rate/rate.blade.php'));
        $this->deleteFile(app_path('Application/Controllers/Admin/'.$command->name.'Controller.php'));
        $this->deleteFile(app_path('Application/Controllers/Website/'.$command->name.'Controller.php'));
        $this->replaceLines("public function ".strtolower($command->name)."(){", app_path('Application/Model/' . ucfirst($command->options) . '.php'));
        $this->replaceFromFile('@include("admin.' . $command->options . '.rate.edit")', app_path('Application/views/admin/'.$command->options.'/rate.blade.php'));
        $this->replaceFromFile('@include("admin.' . $command->options . '.rate.show")' , app_path('Application/views/admin/'.$command->options.'/rate.blade.php'));
        $this->replaceFromFile('@include("website.' . $command->options . '.rate.edit")', app_path('Application/views/website/'.$command->options.'/rate.blade.php'));
        $this->replaceFromFile('@include("website.' .$command->options . '.rate.show")', app_path('Application/views/website/'.$command->options.'/rate.blade.php'));
        $this->replaceFromFile('@include("admin.' . $command->options . '.rate.edit")', app_path('Application/views/admin/'.$command->options.'/rate.blade.php'));
        $this->replaceFromFile('@include("website.' .$command->options . '.rate.edit")', app_path('Application/views/website/'.$command->options.'/rate.blade.php'));
        $this->replaceFromFile('@include("admin.' . $command->options . '.rate.show")', app_path('Application/views/admin/'.$command->options.'/rate.blade.php'));
        $this->replaceFromFile('@include("website.' .$command->options . '.rate.show")', app_path('Application/views/website/'.$command->options.'/rate.blade.php'));

        $dir = app_path('Application/routes/appendWebsite.php');
        $this->replaceFromFile(ucfirst($command->name).'Controller@addRate' ,$dir );
        $this->replaceFromFile('#### '.strtolower($command->options) ,$dir );
        $dir = app_path('Application/routes/admin.php');
        $this->replaceFromFile(ucfirst($command->name).'Controller@addRate' ,$dir );
        $this->replaceFromFile('#### '.strtolower($command->options).' Rate' ,$dir );

        if(file_exists(app_path('Application/routes/'.mb_strtolower($command->options).'.php'))){
            $dir = app_path('Application/routes/'.mb_strtolower($command->options).'.php');
            $this->replaceFromFile(ucfirst($command->name).'Controller@addRate' ,$dir );
            $this->replaceFromFile('#### '.strtolower($command->options).' comment' ,$dir );
        }

        $this->deleteFile(base_path('config/'.mb_strtolower($command->options).'rate.php'));
        Permission::where('name' , 'rate-'.$command->name)->delete();
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists(strtolower($command->options.'rate'));
        Schema::enableForeignKeyConstraints();
    }

    protected function replaceFromFile($key, $path)
    {
        try {
            if (file_exists($path)) {
                $fc = file($path);
                $f = fopen($path, "w");
                foreach ($fc as $line) {
                    if (!strstr($line, $key)) //look for $key in each line
                        fputs($f, $line); //place $line back in file
                }
                fclose($f);
            }
        } catch (\Expection $e) {

        }
    }

    protected function replaceLines($key, $path, $linesNUmber = 3)
    {
        try {
            if (file_exists($path)) {
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
        } catch (\Expection $e) {

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


}
