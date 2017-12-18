<?php

namespace App\Console\Commands;


use App\Application\Model\Group;
use App\Application\Model\Permission;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\File;


class AddRate extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Rate to Model .';
    protected $cols = [];
    protected $relatedMode = null;

    public function handle()
    {
        $this->cols();
        $this->addRelationsOtM();
        $this->createFolders();
        $this->addFrom();
        $this->route();
        $this->addControllerFunction();
        $this->addPermissions('admin', 'addRate', null, 'add');
        $this->addPermissions('website', 'addRate', null, 'add');
    }

    protected function addPermissions($type = 'admin', $method = 'addRate', $overriderAdminOnWebsite = null, $action)
    {
        $overriderAdminOnWebsite = $overriderAdminOnWebsite == null ? $type : $overriderAdminOnWebsite;
        $array = [
            'name' => $action . '-rate-' . ucfirst($this->relatedMode) . ucfirst($this->getNameInput()),
            'slug' => 'App-Application-Controllers-' . ucfirst($overriderAdminOnWebsite) . '-' . ucfirst($this->relatedMode) . ucfirst($this->getNameInput()),
            'description' => 'Allow ' . $type . ' on index in ' . ucfirst($this->relatedMode) . ucfirst($this->getNameInput()) . ' Controller ',
            'controller_name' => ucfirst($this->relatedMode) . ucfirst($this->getNameInput()) . 'Controller',
            'controller_type' => $type,
            'method_name' => $method,
            'permission' => 1,
            'namespace' => 'App\\Application\\Controllers\\' . ucfirst($overriderAdminOnWebsite) . '\\' . ucfirst($this->relatedMode) . ucfirst($this->getNameInput()) . 'Controller'
        ];
        $item = Permission::create($array);
        if ($type == 'admin') {
            $group = Group::find(1);
            $group->permission()->attach($item);
        } else {
            $group = Group::find(2);
            $group->permission()->attach($item);
            $group = Group::find(1);
            $group->permission()->attach($item);
        }

    }

    protected function addControllerFunction()
    {
        $name = strtolower($this->relatedMode);
        $path = $this->getPath('Application\\Controllers\\Admin\\' . ucfirst($this->relatedMode) . 'RateController');
        $this->files->append($path, $this->adminFunction($name, __DIR__ . '/stub/updateAddRateAdminFunction.stub'));
        $path = $this->getPath('Application\\Controllers\\Website\\' . ucfirst($this->relatedMode) . 'RateController');
        $this->files->append($path, $this->adminFunction($name, __DIR__ . '/stub/updateAddRateWebsiteFunction.stub'));
    }

    protected function adminFunction($name, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DummySmall', $name)
            ->replace($stub, 'DummyParent', ucfirst($name))
            ->replaceView($stub, 'Dummy', ucfirst($name) . 'Rate');
    }

    protected function createFolders()
    {
        $this->createFolder('Application/views/admin/' . $this->relatedMode . '/rate');
        $this->createFolder('Application/views/website/' . $this->relatedMode . '/rate');
    }

    protected function route()
    {
        $name = strtolower($this->relatedMode);
        $path = $this->getPath('Application\\routes\\appendWebsite');
        $this->files->append($path, $this->websiteRoute($name, __DIR__ . '/stub/rateWebsite.stub'));
        $path = $this->getPath('Application\\routes\\admin');
        $this->files->append($path, $this->websiteRoute($name, __DIR__ . '/stub/rateWebsite.stub'));
    }

    protected function websiteRoute($name, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DummyRoute', $name)
            ->replaceView($stub, 'Dummy', ucfirst($name) . 'Rate');
    }


    public function addFrom()
    {
        $findAdminEditFile = "</form>" . "\n";
        $adminEdit = app_path('Application/views/admin/' . $this->relatedMode . '/edit.blade.php');
        $this->addLineToFile($adminEdit, $findAdminEditFile, '@include("admin.' . $this->relatedMode . '.rate.rate")' . "\n");
        $this->createFile('Application/views/admin/' . $this->relatedMode . '/rate/rate.blade.php', $this->formGenerator('admin'));

        $adminEdit = app_path('Application/views/website/' . $this->relatedMode . '/edit.blade.php');
        $this->addLineToFile($adminEdit, $findAdminEditFile, '@include("website.' . $this->relatedMode . '.rate.rate")' . "\n");
        $this->createFile('Application/views/website/' . $this->relatedMode . '/rate/rate.blade.php', $this->formGenerator('website'));

        $findAdminEditFile = "</table>" . "\n";
        $adminEdit = app_path('Application/views/admin/' . $this->relatedMode . '/show.blade.php');
        $this->addLineToFile($adminEdit, $findAdminEditFile, '@include("admin.' . $this->relatedMode . '.rate.rate")' . "\n");

        $adminEdit = app_path('Application/views/website/' . $this->relatedMode . '/show.blade.php');
        $this->addLineToFile($adminEdit, $findAdminEditFile, '@include("website.' . $this->relatedMode . '.rate.rate")' . "\n");
    }

    public function addTR()
    {
//        $findAdminEditFile = "</table>" . "\n";
//        $adminEdit = app_path('Application/views/admin/' . $this->relatedMode . '/show.blade.php');
//        $this->addLineToFile($adminEdit, $findAdminEditFile, '@include("admin.' . $this->relatedMode . '.rate.show")' . "\n");
//        $this->createFile('Application/views/admin/' . $this->relatedMode . '/rate/show.blade.php', $this->trGenerator("admin"));
//
//        $adminEdit = app_path('Application/views/website/' . $this->relatedMode . '/show.blade.php');
//        $this->addLineToFile($adminEdit, $findAdminEditFile, '@include("website.' . $this->relatedMode . '.rate.show")' . "\n");
//        $this->createFile('Application/views/website/' . $this->relatedMode . '/rate/show.blade.php', $this->trGenerator("website"));
    }

    public function trGenerator($admin = "admin")
    {
        $admin = $admin == 'admin' ? 'admin/' : '';
        $out = "\t\t" . '@isset($item->id) ' . "\n";
        $out .= "\t\t" . '@php ' . "\n";
        $out .= "\t\t\t" . ' $rates = \App\Application\Model\\' . ucfirst($this->relatedMode) . $this->getNameInput() . '::where("' . $this->relatedMode . '_id" ,$item->id )->with("user")->get(); ' . "\n";
        $out .= "\t\t\t" . ' $rateBefore = \App\Application\Model\\' . ucfirst($this->relatedMode) . $this->getNameInput() . '::where("' . $this->relatedMode . '_id" ,$item->id )->where("user_id" , auth()->user()->id)->count(); ' . "\n";
        $out .= "\t\t\t" . '$countRate = $rates->count() ;' . "\n";
        $out .= "\t\t\t" . '$sumRate = $rates->sum("rate") ;' . "\n";
        $out .= "\t\t" . ' @endphp' . "\n";
        $out .= "\t\t\t" . '<h3>{{ trans( "admin.Rates") }} ({{ $countRate }})</h3>' . "\n";
        $out .= "\t\t" . ' @if($rateBefore == 0)' . "\n";
        $out .= "\t\t\t" . '<form method="post" action="{{ concatenateLangToUrl("' . $admin . $this->relatedMode . '/add/rate/".$item->id) }}" > {{ csrf_field() }}' . "\n";
        $out .= "\t\t\t" . '<div class="form-group" > ' . "\n";
        $out .= "\t\t\t\t" . '<label for="rate" > {{ trans("admin.Rate") }}</label > ' . "\n";
        $out .= "\t\t\t\t" . '<select id="rate" name="rate">' . "\n";
        $out .= "\t\t\t\t" . '<option value="1"> 1</option> ' . "\n";
        $out .= "\t\t\t\t" . '<option value="2"> 2</option> ' . "\n";
        $out .= "\t\t\t\t" . '<option value="3"> 3</option> ' . "\n";
        $out .= "\t\t\t\t" . '<option value="4"> 4</option> ' . "\n";
        $out .= "\t\t\t\t" . '<option value="5"> 5</option> ' . "\n";
        $out .= "\t\t\t\t" . '</select> ' . "\n";
        $out .= "\t\t\t" . '</div> ' . "\n";
        $out .= "\t\t\t" . '</form> ' . "\n";
        $out .= "\t\t\t" . '@else' . "\n";
        $out .= "\t\t\t\t" . '@for($i = 1 ; $i <= 5 ;$i++)' . "\n";
        $out .= "\t\t\t\t\t\t" . '{!! $i <= ($sumRate / $countRate) ? "<i class=\'fa fa-star active\'></i>"  : "<i class=\'fa fa-star \'></i>" !!}' . "\n";
        $out .= "\t\t\t\t" . '@endfor' . "\n";
        $out .= "\t\t" . '@endif' . "\n";
        $out .= "\t\t" . '@endisset' . "\n";
        return $out;
    }


    public function formGenerator($admin , $action = 'add')
    {
        $admin = $admin == 'admin' ? 'admin/' : '';
        $out = "\t\t" . '@isset($item->id) ' . "\n";
        $out .= "\t\t" . '@php ' . "\n";
        $out .= "\t\t\t" . ' $rates = \App\Application\Model\\' . ucfirst($this->relatedMode) . $this->getNameInput() . '::where("' . $this->relatedMode . '_id" ,$item->id )->with("user")->get(); ' . "\n";
        $out .= "\t\t\t" . ' $rateBefore = \App\Application\Model\\' . ucfirst($this->relatedMode) . $this->getNameInput() . '::where("' . $this->relatedMode . '_id" ,$item->id )->where("user_id" , auth()->user()->id)->count(); ' . "\n";
        $out .= "\t\t\t" . '$countRate = $rates->count() ;' . "\n";
        $out .= "\t\t\t" . '$sumRate = $rates->sum("rate") ;' . "\n";
        $out .= "\t\t" . ' @endphp' . "\n";
        $out .= "\t\t\t" . '<h3>{{ trans( "admin.Rates") }} ({{ $countRate }})</h3>' . "\n";
        $out .= "\t\t" . ' @if($rateBefore == 0)' . "\n";
        $out .= "\t\t\t" . '<form method="post" action="{{ concatenateLangToUrl("' . $admin . $this->relatedMode . '/add/rate/".$item->id) }}" > {{ csrf_field() }}' . "\n";
        $out .= "\t\t\t" . '<div class="form-group" > ' . "\n";
        $out .= "\t\t\t\t" . '<label for="rate" > {{ trans("admin.Rate") }}</label > ' . "\n";
        $out .= "\t\t\t\t" . '<select id="rate" name="rate">' . "\n";
        $out .= "\t\t\t\t" . '<option value="1"> 1</option> ' . "\n";
        $out .= "\t\t\t\t" . '<option value="2"> 2</option> ' . "\n";
        $out .= "\t\t\t\t" . '<option value="3"> 3</option> ' . "\n";
        $out .= "\t\t\t\t" . '<option value="4"> 4</option> ' . "\n";
        $out .= "\t\t\t\t" . '<option value="5"> 5</option> ' . "\n";
        $out .= "\t\t\t\t" . '</select> ' . "\n";
        $out .= "\t\t\t" . '</div> ' . "\n";
        $out .= "\t\t\t" . '</form> ' . "\n";
        $out .= "\t\t\t" . '@else' . "\n";
        $out .= "\t\t\t\t" . '@for($i = 1 ; $i <= 5 ;$i++)' . "\n";
        $out .= "\t\t\t\t\t\t" . '{!! $i <= ($sumRate / $countRate) ? "<i class=\'fa fa-star active\'></i>"  : "<i class=\'fa fa-star \'></i>" !!}' . "\n";
        $out .= "\t\t\t\t" . '@endfor' . "\n";
        $out .= "\t\t" . '@endif' . "\n";
        $out .= "\t\t" . '@endisset' . "\n";
        return $out;
    }

    public function cols()
    {
        if ($this->option('cols')) {
            $cols = $this->option('cols');
            $sendCols = explode(',', $cols);
            $this->relatedMode = $sendCols[0];
            $colsToModel = isset($sendCols[1]) ? $sendCols[1] : '';
            if (Schema::hasTable($this->relatedMode . 'rate')) {
                Schema::disableForeignKeyConstraints();
                Schema::drop($this->relatedMode . 'rate');
                Schema::enableForeignKeyConstraints();
            }
            if (!file_exists(app_path('Application/Model/' . ucfirst($this->getNameInput())) . '.php')) {
                $this->call('laraflat:model', ['name' => class_basename(ucfirst($this->relatedMode) . $this->getNameInput()), '--cols' => $colsToModel . $this->appendDefaultCols()]);
            }
        } else {
            if (!file_exists(app_path('Application/Model/' . ucfirst($this->getNameInput())) . '.php')) {
                $this->call('laraflat:model', ['name' => class_basename($this->getNameInput())]);
            }
        }
    }


    protected function appendDefaultCols()
    {
        return ',user_id:integer::false,' . $this->relatedMode . '_id:integer::false,rate:string:min-1_max-5_required_integer:false';
    }


    protected function addRelationsOtM()
    {
        $string = 'public $table = "' . $this->relatedMode . '";' . "\n";
        $string1 = 'public $table = "' . $this->relatedMode . strtolower($this->getNameInput()) . '";' . "\n";
        $modelnameP = app_path("Application/Model/" . ucfirst($this->relatedMode) . '.php');
        $modelnameF = app_path("Application/Model/" . ucfirst($this->relatedMode) . $this->getNameInput() . '.php');
        $this->addLineToFile($modelnameP, $string, $this->hasMany(ucfirst($this->relatedMode) . $this->getNameInput(), $this->relatedMode . '_id', $this->relatedMode . strtolower($this->getNameInput())));
        $this->addLineToFile($modelnameF, $string1, $this->belongsTo(ucfirst($this->relatedMode), $this->relatedMode . '_id', $this->relatedMode));
        $this->addLineToFile($modelnameF, $string1, $this->belongsTo("User", 'user_id', "user"));
    }

    protected function hasMany($model, $col, $name)
    {
        $out = "public function " . $name . "(){" . "\n";
        $out .= "\t\t" . 'return $this->hasMany(' . $model . '::class, "' . $col . '");' . "\n";
        $out .= "\t\t" . "}" . "\n";
        return $out;
    }

    protected function belongsTo($model, $col, $name)
    {
        $out = "public function " . $name . "(){" . "\n";
        $out .= "\t\t" . 'return $this->belongsTo(' . $model . '::class, "' . $col . '");' . "\n";
        $out .= "\t\t" . "}" . "\n";
        return $out;
    }


    protected function addLineToFile($src, $text, $append)
    {
        $fc = file($src);
        $f = fopen($src, "w");
        foreach ($fc as $line) {
            $out = '';
            $tabs = strlen($line) - strlen(ltrim($line));
            for ($i = 0; $i < $tabs; $i++) {
                $out .= ' ';
            }
            $line = ltrim($line);
            if (!strstr($line, $text)) {
                fputs($f, $out . $line); //place $line back in file
            } else {
                fputs($f, $out . $line);
                fputs($f, $out . $append);
            }
        }
        fclose($f);
    }

    protected function getStub()
    {

    }

    protected function getOptions()
    {
        return [
            ['cols', 'c', InputArgument::OPTIONAL, 'Create Rate model']
        ];
    }

    protected function createFolder($path)
    {
        try {
            if (!file_exists($path)) {
                File::makeDirectory(app_path($path), 0775, true, true);
            }
        } catch (\Exception $e) {

        }
    }

    protected function createFile($path, $content)
    {
        if (!file_exists(app_path($path))) {
            File::put(app_path($path), $content, 0775);
        }
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

    protected function replace(&$stub, $rep, $name)
    {
        $stub = str_replace(
            [$rep],
            $name,
            $stub
        );
        return $this;
    }
}
