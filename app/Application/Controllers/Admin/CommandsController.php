<?php

namespace App\Application\Controllers\Admin;

use App\Application\Controllers\AbstractController;
use Alert;
use App\Application\Model\Command;
use App\Application\Model\Item;
use App\Application\Model\Relation;
use App\Application\Model\User;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Mcamara\LaravelLocalization\LaravelLocalization;


class CommandsController extends AbstractController
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        $commands = $this->laraFlatCommands();
        $migrationTypes = $this->migrationType();
        $validationTypes = $this->validationTypes();
        $history = Command::get();
        $models = getModels();
        return view('admin.commands.index', compact('commands', 'migrationTypes', 'validationTypes', 'history', 'models'));
    }

    public function command()
    {
        $commands = $this->commands();
        return view('admin.commands.other', compact('commands'));
    }

    public function otherExe(Request $request)
    {
        if ($request->commands == 'migrate') {
            $this->clearAllTables();
            Artisan::call($request->commands);
            Artisan::call("db:seed");
        } else {
            Artisan::call($request->commands);
        }
        shell_exec('composer --working-dir=' . app_path("/") . ' dumpautoload');
        alert()->success(trans('admin.Done'));
        return redirect()->back()->withInput();
    }

    protected function clearAllTables()
    {
        Schema::disableForeignKeyConstraints();
        $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
        foreach ($tableNames as $name) {
            Schema::dropIfExists($name);
        }
        Schema::enableForeignKeyConstraints();
    }

    protected function commands()
    {
        return [
            'migrate',
            'db:seed',
            'cache:clear',
            'cache:forget',
            'route:cache',
            'route:clear',
            'storage:link',
            'view:clear',
            'lang:sync'
        ];
    }

    public function exe(Request $request)
    {
        if ($request->name) {
            if (in_array($request->commands, $this->commands()) && $request->commands != 'laraflat:admin_model') {
                $this->artisanCall($request->commands, ucfirst($request->name));
            } else {
                $check = is_array($request->colsName) ? $request->colsName : [];
                if (count($check) > 0 || $request->has('foreign_key')) {
                    $cols = $this->handelRequest($request);
                    $name = $request->has('foreign_key') ? ucfirst($request->foreign_key) . ucfirst($request->name) : ucfirst($request->name);
                    $this->artisanCall($request->commands, ucfirst($request->name), $cols, $name);
                } else {
                    $this->artisanCall($request->commands, ucfirst($request->name));
                }
            }
            alert()->success(trans('admin.Done'));
            return redirect()->back()->withInput();
        }
        alert()->error(trans('admin.Error'));
        return redirect()->back()->withInput();
    }

    protected function artisanCall($command, $name, $cols = null, $nameColm = null)
    {
        $nameColm = $nameColm == null ? $name : $nameColm;
        $array = [
            'name' => $nameColm,
            'command' => $command,
            'options' => $cols
        ];
        Command::create($array);
        if ($cols == null) {
            return Artisan::call($command, ['name' => $name]);
        }
        Artisan::call($command, ['name' => $name, '--cols' => $cols]);
        Artisan::call("migrate");
        Artisan::call('langman:sync');
        return true;
    }


    protected function handelRequest($request)
    {
        $colsOption = "";
        if ($request->has('foreign_key')) {
            $colsOption .= $request->foreign_key;
            $request->colsName ? ',' : '';
        }
        if ($request->colsName) {
            $count = 0;
            foreach ($request->colsName as $key => $cols) {
                $count++;
                $lang = $request->lang[$key] == 0 ? 'false' : 'true';
                $index = $request->validation[$key] ?? [];
                $rule = $request->validationVal[$key] ?? [];
                $validation = $this->handelValidation($index, $rule);
                $colsOption .= $cols . ':' . $request->migration[$key] . ':' . $validation . ':' . $lang;
                if ($count != count($request->colsName)) {
                    $colsOption .= ',';
                }
            }
        }

        return $colsOption;
    }

    protected function handelValidation($validation, $vVlaue)
    {
        $out = '';
        if (is_array($validation)) {
            $count = 0;
            foreach ($validation as $key => $value) {
                $count++;
                if (key_exists($key, $vVlaue) && $vVlaue[$key] != null) {
                    $out .= $key . '-' . $vVlaue[$key];
                    if ($count != count($validation)) {
                        $out .= '_';
                    }
                } else {
                    $out .= $key;
                    if ($count != count($validation)) {
                        $out .= '_';
                    }
                }
            }
        }
        return $out;
    }

    protected function migrationType()
    {
        return getMigrationType();
    }

    protected function validationTypes()
    {
        return [
            'min' => true,
            'max' => true,
            'image' => true,
            'required' => false,
            'nullable' => false,
            'email' => false,
            'date' => false,
            'boolean' => false,
            'ip' => false,
            'integer' => false,
            'url' => false,
            'array' => false,
        ];
    }

    protected function laraFlatCommands()
    {
        return [
//            'laraflat:admin_controller',
                'laraflat:admin_model' => trans('admin.Form Builder'),
                'laraflat:comment' => trans('admin.Add Comment to Module'),
                'laraflat:rate' => trans('admin.Add Rate to Module'),
//            'laraflat:admin_request',
//            'laraflat:api_controller',
//            'laraflat:api_request',
//            'laraflat:controller',
//            'laraflat:datatable',
//            'laraflat:interface',
//            'laraflat:migrate',
//            'laraflat:model',
//            'laraflat:request',
//            'laraflat:rollback',
//            'laraflat:transformer'
        ];
    }

    public function haveCommand(Request $request)
    {
        if ($request->name) {
            $this->artisanCall('laraflat:admin_model', ucfirst($request->name), $request->cols, $request->name);
            alert()->success(trans('admin.Done'));
            return redirect()->back()->withInput();
        }
        alert()->error(trans('admin.Error'));
        return redirect()->back()->withInput();
    }

    public function exportEmportModels()
    {
        $models = array_except(getModels(), 'user');
        return view('admin.commands.exportImport', compact('models'));
    }

    public function export(Request $request)
    {
        if ($request->primary_key && $request->primary_key != '') {
            $name = ucfirst($request->primary_key);

            /*
             * delete files firsts
             */
            File::deleteDirectory(base_path('Models\\' . $name));
            /*
             * create new Directory
             */
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\resources'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\config'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\database'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\database\\migrations'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\resources\\lang'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application\\Controllers'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application\\Controllers\\Admin'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application\\Controllers\\Website'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application\\Controllers\\Api'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application\\DataTables'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application\\Model'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application\\Requests'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application\\Requests\\Admin'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application\\Requests\\Website'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application\\routes'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application\\Transformers'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application\\views'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application\\views\\admin'), 0775, true, true);
            File::makeDirectory(base_path('Models\\' . $name . '\\app\\Application\\views\\website'), 0775, true, true);
            $smallName = strtolower($name);
            File::copy(base_path('app\\Application\\Controllers\\Admin\\' . $name . 'Controller.php'), base_path('Models\\' . $name . '\\app\\Application\\Controllers\\Admin\\' . $name . 'Controller.php'));
            File::copy(base_path('app\\Application\\Controllers\\Website\\' . $name . 'Controller.php'), base_path('Models\\' . $name . '\\app\\Application\\Controllers\\Website\\' . $name . 'Controller.php'));
            File::copy(base_path('app\\Application\\Model\\' . $name . '.php'), base_path('Models\\' . $name . '\\app\\Application\\Model\\' . $name . '.php'));
            File::copy(base_path('app\\Application\\Controllers\\Api\\' . $name . 'Api.php'), base_path('Models\\' . $name . '\\app\\Application\\Controllers\\Api\\' . $name . 'Api.php'));
            File::copy(base_path('app\\Application\\DataTables\\' . $name . 'sDataTable.php'), base_path('Models\\' . $name . '\\app\\Application\\DataTables\\' . $name . 'sDataTable.php'));
            File::copy(base_path('app\\Application\\Transformers\\' . $name . 'Transformers.php'), base_path('Models\\' . $name . '\\app\\Application\\Transformers\\' . $name . 'Transformers.php'));
            File::copyDirectory(base_path('app\\Application\\views\\admin\\' . $smallName), base_path('Models\\' . $name . '\\app\\Application\\views\\admin\\' . $smallName));
            File::copyDirectory(base_path('app\\Application\\views\\website\\' . $smallName), base_path('Models\\' . $name . '\\app\\Application\\views\\website\\' . $smallName));
            File::copyDirectory(base_path('app\\Application\\Requests\\Admin\\' . $name), base_path('Models\\' . $name . '\\app\\Application\\Requests\\Admin\\' . $name));
            File::copyDirectory(base_path('app\\Application\\Requests\\Website\\' . $name), base_path('Models\\' . $name . '\\app\\Application\\Requests\\Website\\' . $name));
            $localize = new LaravelLocalization();
            foreach ($localize->getSupportedLocales() as $localeCode => $properties) {
                File::makeDirectory(base_path('Models\\' . $name . '\\resources\\lang\\' . $localeCode), 0775, true, true);
                File::copy(base_path('resources\\lang\\' . $localeCode . '\\' . $smallName . '.php'), base_path('Models\\' . $name . '\\resources\\lang\\' . $localeCode . '\\' . $smallName . '.php'));
            }
            if (file_exists(base_path('config\\' . $smallName . '.php'))) {
                File::copy(base_path('config\\' . $smallName . '.php'), base_path('Models\\' . $name . '\\config\\' . $smallName . '.php'));
            }
            if (file_exists(base_path('config\\' . $smallName . 'comment.php'))) {
                File::copy(base_path('config\\' . $smallName . 'comment.php'), base_path('Models\\' . $name . '\\config\\' . $smallName . 'comment.php'));
            }
            if (file_exists(base_path('config\\' . $smallName . 'rate.php'))) {
                File::copy(base_path('config\\' . $smallName . 'rate.php'), base_path('Models\\' . $name . '\\config\\' . $smallName . 'rate.php'));
            }
            /*
             * route files
             */
            $content = "<?php
                #### {$name} control
                Route::get('{$smallName}', '{$name}Controller@index');
                Route::get('{$smallName}/item/{id?}', '{$name}Controller@show');
                Route::post('{$smallName}/item', '{$name}Controller@store');
                Route::post('{$smallName}/item/{id}', '{$name}Controller@update');
                Route::get('{$smallName}/{id}/delete', '{$name}Controller@destroy');
                Route::get('{$smallName}/{id}/view', '{$name}Controller@getById');";

            $apiContent = "<?php
            #{$name}
            Route::get('{$smallName}/getById/{id}/{lang?}', '{$name}Api@getById');
            Route::get('{$smallName}/delete/{id}', '{$name}Api@delete');
            Route::post('{$smallName}/add', '{$name}Api@add');
            Route::post('{$smallName}/update/{id}', '{$name}Api@update');
            Route::get('{$smallName}/{limit?}/{offset?}/{lang?}', '{$name}Api@index');";
            File::copy(base_path('app\\Application\\routes\\auth.php'), base_path('Models\\' . $name . '\\app\\Application\\routes\\' . strtolower($name) . '.php'));
            File::copy(base_path('app\\Application\\routes\\auth.php'), base_path('Models\\' . $name . '\\app\\Application\\routes\\' . strtolower($name) . 'api.php'));
            $bytes_written = File::put(base_path('Models\\' . $name . '\\app\\Application\\routes\\' . strtolower($name) . '.php'), $content);
            if ($bytes_written === false) {
                die("Error writing to file");
            }
            $bytes_written = File::put(base_path('Models\\' . $name . '\\app\\Application\\routes\\' . strtolower($name) . 'api.php'), $apiContent);
            if ($bytes_written === false) {
                die("Error writing to file");
            }
            /*
             * migration section
             */
            $migrationPath = database_path('migrations');
            foreach (scandir($migrationPath) as $file) {
                $migration = explode('_', $file);
                if (isset($migration[4]) && isset($migration[5]) && isset($migration[6])) {
                    $migration_name = $migration[4] . '_' . $migration[5] . '_' . $migration[6];
                    if ($migration_name == 'create_' . strtolower($name) . '_table.php') {
                        File::copy(database_path('migrations/' . $file), base_path('Models\\' . $name . '\\database\\migrations\\' . $file));
                    }
                    if ($migration_name == 'create_' . strtolower($name) . 'comment' . '_table.php') {
                        File::copy(database_path('migrations/' . $file), base_path('Models\\' . $name . '\\database\\migrations\\' . $file));
                        File::copy(base_path('app\\Application\\Controllers\\Admin\\' . $name . 'CommentController.php'), base_path('Models\\' . $name . '\\app\\Application\\Controllers\\Admin\\' . $name . 'CommentController.php'));
                        File::copy(base_path('app\\Application\\Controllers\\Website\\' . $name . 'CommentController.php'), base_path('Models\\' . $name . '\\app\\Application\\Controllers\\Website\\' . $name . 'CommentController.php'));
                        File::copy(base_path('app\\Application\\Model\\' . $name . 'Comment.php'), base_path('Models\\' . $name . '\\app\\Application\\Model\\' . $name . 'Comment.php'));
                        File::copyDirectory(base_path('app\\Application\\Requests\\Admin\\' . $name . 'Comment'), base_path('Models\\' . $name . '\\app\\Application\\Requests\\Admin\\' . $name . 'Comment'));
                        File::copyDirectory(base_path('app\\Application\\Requests\\Website\\' . $name . 'Comment'), base_path('Models\\' . $name . '\\app\\Application\\Requests\\Website\\' . $name . 'Comment'));
                        $content = "
                        Route::post('{$smallName}/add/comment/{id}' , '{$name}CommentController@addComment');
                        Route::post('{$smallName}/update/comment/{id}' , '{$name}CommentController@updateComment');
                        Route::get('{$smallName}/delete/comment/{id}' , '{$name}CommentController@deleteComment');
                        ";
                        $bytesWritten = File::append(base_path('Models\\' . $name . '\\app\\Application\\routes\\' . strtolower($name) . '.php'), $content);
                        if ($bytesWritten === false) {
                            die("Couldn't write to the file.");
                        }
                    }
                    if ($migration_name == 'create_' . strtolower($name) . 'rate' . '_table.php') {
                        File::copy(database_path('migrations/' . $file), base_path('Models\\' . $name . '\\database\\migrations\\' . $file));
                        File::copy(base_path('app\\Application\\Controllers\\Admin\\' . $name . 'RateController.php'), base_path('Models\\' . $name . '\\app\\Application\\Controllers\\Admin\\' . $name . 'RateController.php'));
                        File::copy(base_path('app\\Application\\Controllers\\Website\\' . $name . 'RateController.php'), base_path('Models\\' . $name . '\\app\\Application\\Controllers\\Website\\' . $name . 'RateController.php'));
                        File::copy(base_path('app\\Application\\Model\\' . $name . 'Rate.php'), base_path('Models\\' . $name . '\\app\\Application\\Model\\' . $name . 'Rate.php'));
                        File::copyDirectory(base_path('app\\Application\\Requests\\Admin\\' . $name . 'Rate'), base_path('Models\\' . $name . '\\app\\Application\\Requests\\Admin\\' . $name . 'Rate'));
                        File::copyDirectory(base_path('app\\Application\\Requests\\Website\\' . $name . 'Rate'), base_path('Models\\' . $name . '\\app\\Application\\Requests\\Website\\' . $name . 'Rate'));

                        $content = "
                         #### post Rate
                        Route::post('{$smallName}/add/rate/{id}' , '{$name}RateController@addRate');
                        ";
                        $bytesWritten = File::append(base_path('Models\\' . $name . '\\app\\Application\\routes\\' . strtolower($name) . '.php'), $content);
                        if ($bytesWritten === false) {
                            die("Couldn't write to the file.");
                        }
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
                            $r = $rel->p == 'user' ? 'user_' . $smallName : $rel->name;
                            if ($migration_name == 'create_' . $r . '_table.php') {
                                if (file_exists(base_path('Models/' . $name . '/config/' . $smallName . '.php'))) {
                                    $value = File::getRequire(base_path('Models/' . $name . '/config/' . $smallName . '.php'));


                                    $value['relation'][] = $rel->toArray();
                                    $out = "<?php 
                                        return [" . "\n";
                                    foreach ($value as $key => $va) {
                                        $out .= "'{$key}' => [" . "\n";
                                        foreach ($va as $k => $v) {
                                            if (is_array($v)) {
                                                $out .= "'{$k}' => [" . "\n";
                                                foreach ($v as $y => $z) {
                                                    $out .= "'{$y}' => '{$z}'," . "\n";
                                                }
                                                $out .= "]," . "\n";
                                            } else {
                                                $out .= "'{$k}' => '{$v}'," . "\n";
                                            }
                                        }

                                        $out .= "]," . "\n";
                                    }
                                    $out .= "];" . "\n";
                                    $bytes_written = File::put(base_path('Models/' . $name . '/config/' . $smallName . '.php'), $out);

                                    if ($bytes_written === false) {
                                        die("Error writing to file");
                                    }
                                }
                                File::copy(database_path('migrations/' . $file), base_path('Models\\' . $name . '\\database\\migrations\\' . $file));
                            }
                        }
                    }
                }
            }
            $relation = Relation::where('p', strtolower($name))->get();
            if (count($relation) > 0) {
                foreach ($relation as $rel) {
                    foreach (scandir($migrationPath) as $file) {
                        $migration = explode('_', $file);
                        if (isset($migration[4]) && isset($migration[5]) && isset($migration[6]) && isset($migration[7])) {
                            $migration_name = $migration[4] . '_' . $migration[5] . '_' . $migration[6] . '_table.php';
                            $r = $rel->f == 'user' ? 'user_' . $smallName : $rel->name;
                            if ($migration_name == 'create_' . $r . '_table.php') {
                                if (file_exists(base_path('Models/' . $name . '/config/' . $smallName . '.php'))) {
                                    $value = File::getRequire(base_path('Models/' . $name . '/config/' . $smallName . '.php'));
                                    $value['relation'][] = $rel->toArray();
                                    $out = "<?php 
                                        return [" . "\n";
                                    foreach ($value as $key => $va) {
                                        $out .= "'{$key}' => [" . "\n";
                                        foreach ($va as $k => $v) {
                                            if (is_array($v)) {
                                                $out .= "'{$k}' => [" . "\n";
                                                foreach ($v as $y => $z) {
                                                    $out .= "'{$y}' => '{$z}'," . "\n";
                                                }
                                                $out .= "]," . "\n";
                                            } else {
                                                $out .= "'{$k}' => '{$v}'," . "\n";
                                            }
                                        }

                                        $out .= "]," . "\n";
                                    }
                                    $out .= "];" . "\n";

                                    $bytes_written = File::put(base_path('Models/' . $name . '/config/' . $smallName . '.php'), $out);

                                    if ($bytes_written === false) {
                                        die("Error writing to file");
                                    }
                                }
                                File::copy(database_path('migrations/' . $file), base_path('Models\\' . $name . '\\database\\migrations\\' . $file));
                            }
                        }
                    }
                }
            }

            $command = Command::where('name', $name)->where('command', 'laraflat:admin_model')->first();
            if ($command) {
                if (file_exists(base_path('Models/' . $name . '/config/' . $smallName . '.php'))) {
                    $value = File::getRequire(base_path('Models/' . $name . '/config/' . $smallName . '.php'));


                    $value['command'] = $command->toArray();
                    $out = "<?php 
                        return [" . "\n";
                    foreach ($value as $key => $va) {
                        $out .= "'{$key}' => [" . "\n";
                        foreach ($va as $k => $v) {
                            if (is_array($v)) {
                                $out .= "'{$k}' => [" . "\n";
                                foreach ($v as $y => $z) {
                                    $out .= "'{$y}' => '{$z}'," . "\n";
                                }
                                $out .= "]," . "\n";
                            } else {
                                $out .= "'{$k}' => '{$v}'," . "\n";
                            }
                        }

                        $out .= "]," . "\n";
                    }
                    $out .= "];" . "\n";
                    $bytes_written = File::put(base_path('Models/' . $name . '/config/' . $smallName . '.php'), $out);

                    if ($bytes_written === false) {
                        die("Error writing to file");
                    }
                }
            }

            File::delete(public_path('Models/' . $name . '.zip'));
            /* compress */
            $files = glob(base_path('Models/' . $name . '*'));
            Zipper::make(public_path('Models/' . $name . '.zip'))->add($files)->close();
            File::deleteDirectory(base_path('Models\\' . $name));
            return response()->download(public_path('Models/' . $name . '.zip'));
        }
        alert()->error(trans('admin.Error'));
        return redirect()->back()->withInput();
    }

    public function import(Request $request)
    {
        if ($request->file('package')) {
            if ($request->file('package')->getClientOriginalExtension() == 'zip') {
                $package = $request->file('package');
                $destinationPath = base_path('Models');
                $name = explode('.', $package->getClientOriginalName())[0];
                File::delete(base_path('Models/' . $name . '.zip'));
                File::deleteDirectory(base_path('Models\\' . $name));
                if ($package->move($destinationPath, $package->getClientOriginalName())) {
                    Zipper::make(base_path('Models/' . $package->getClientOriginalName()))->extractTo(base_path('Models/' . $name));
                    $smallName = strtolower($name);
                    $files = File::allFiles(base_path('Models\\' . $name));
                    $packagePathModel = base_path('Models\\' . $name);
                    $packagePathModel = explode(DS, $packagePathModel);
                    $packagePathModelWithouTModelName = base_path('Models');
                    $packagePathModelWithouTModelName = explode(DS, $packagePathModelWithouTModelName);
                    $arrayModelWithoutModelNAme = ['AddRequest' . $name . '.php', 'UpdateRequest' . $name . '.php', 'ApiUpdateRequest' . $name . '.php', 'ApiAddRequest' . $name . '.php'];

                    File::copyDirectory(base_path('Models\\' . $name . '\\app\\Application\\views\\admin\\' . $smallName) , base_path('app\\Application\\views\\admin\\' . $smallName ));
                    File::copyDirectory(base_path('Models\\' . $name . '\\app\\Application\\views\\website\\' . $smallName) , base_path('app\\Application\\views\\website\\' . $smallName ));
                    $list = File::directories(base_path('Models\\' . $name . '\\app\\Application\\Requests\\Admin') );
                    foreach($list as $l){
                        $e = explode(DS , $l);
                        $p = array_pop($e);
                        File::copyDirectory($l , base_path('\\app\\Application\\Requests\\Admin\\' . $p ));
                    }
                    $list = File::directories(base_path('Models\\' . $name . '\\app\\Application\\Requests\\Website') );
                    foreach($list as $l){
                        $e = explode(DS , $l);
                        $p = array_pop($e);
                        File::copyDirectory($l , base_path('\\app\\Application\\Requests\\Website\\' . $p ));
                    }
               

                    foreach ($files as $file) {
                        $array = explode(DS, (string)$file);
                        $f = array_pop($array);
                        if (in_array($f, $arrayModelWithoutModelNAme)) {
                            $p = array_diff($array, $packagePathModelWithouTModelName);
                        } else {
                            $p = array_diff($array, $packagePathModel);
                        }
                        $path = implode(DS, $p);
                     
                        if (File::exists(base_path($path)) && File::isDirectory(base_path($path))) {
                            if ($f == $name . 'Comment.php') {
                                $this->insertToCommand($name . 'Comment', 'laraflat:comment', mb_strtolower($name));
                            }
                            if ($f == $name . 'Rate.php') {
                                $this->insertToCommand($name . 'Rate', 'laraflat:rate', mb_strtolower($name));
                            }
                            File::copy(base_path('Models\\' . $name . '\\' . $path . '\\' . $f), base_path($path . '\\' . $f));
                        }
                    }


                    if (file_exists(base_path('Models/' . $name . '/config/' . $smallName . '.php'))) {
                        $value = File::getRequire(base_path('Models/' . $name . '/config/' . $smallName . '.php'));
                        if (array_key_exists('relation', $value)) {
                            foreach ($value['relation'] as $relation) {
                                Relation::create($relation);
                            }
                        }
                        if (array_key_exists('command', $value)) {
                            Command::create($value['command']);
                        }
                    }

                    $content = "require_once __DIR__ . '/{$smallName}.php';";
                    $bytesWritten = File::append(app_path('Application\routes\admin.php'), $content);
                    if ($bytesWritten === false) {
                        die("Couldn't write to the file.");
                    }
                    $bytesWritten = File::append(app_path('Application\routes\appendWebsite.php'), $content);
                    if ($bytesWritten === false) {
                        die("Couldn't write to the file.");
                    }
                    $content = "require_once __DIR__ . '/{$smallName}api.php';";
                    $bytesWritten = File::append(app_path('Application\routes\appendApi.php'), $content);
                    if ($bytesWritten === false) {
                        die("Couldn't write to the file.");
                    }
                    $this->insertItem($name, 1, '/admin/' . strtolower($name));
                    $this->insertItem($name, 3, strtolower($name), '<i class="fa fa-plus-square-o" aria-hidden="true"></i> ');

                    shell_exec('composer --working-dir=' . app_path("/") . ' dumpautoload');
                    Artisan::call('migrate');
                    Artisan::call('db:seed', ['--class' => 'Permissions']);
                    File::delete(base_path('Models/' . $name . '.zip'));
                    File::deleteDirectory(base_path('Models\\' . $name));

                    alert()->success(trans('admin.Done'));
                    return redirect()->back()->withInput();
                }
            alert()->error(trans('admin.Upload Error'), trans('admin.Error'));
            return redirect()->back()->withInput();
        }
        alert()->error(trans('admin.The Model Extension must be zip '), trans('admin.Error'));
        return redirect()->back()->withInput();
    }
alert()->error(trans('admin.You must Select Package'), trans('admin.Error'));
return redirect()->back()->withInput();

}

protected
function insertItem($name, $menu_id, $link, $icon = '<i class="material-icons">control_point</i>')
{
    $controllerPath = $menu_id == 1 ? 'Admin' : 'Website';
    $order = Item::count();
    $menu = new Item();
    $menu->name = encodeJson(['en' => $name, 'ar' => $name]);
    $menu->link = $link;
    $menu->parent_id = 0;
    $menu->menu_id = $menu_id;
    $menu->order = $order + 1;
    $menu->type = '';
    $menu->icon = $icon;
    $path = 'App\\Application\\Controllers\\'.$controllerPath.'\\'.$name.'Controller';
    $menu->controller_path = json_encode([$path]);
    $menu->save();
}

protected
function insertToCommand($name, $commandFlag, $option)
{
    $command = new Command();
    $command->name = $name;
    $command->command = $commandFlag;
    $command->options = $option;
    $command->save();
}

}
