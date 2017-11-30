<?php

namespace App\Console\Commands;


use App\Application\Model\Group;
use App\Application\Model\Permission;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\File;


class AddComment extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:comment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Comment to Model .';
    protected $cols = [];
    protected $relatedMode = null;

    public function handle()
    {
        $this->cols();
        $this->addRelationsOtM();
        $this->createFolders();
        $this->addFrom();
        $this->addTR();
        $this->route();
        $this->addControllerFunction();
        $this->addPermissions('admin' , 'addComment' , null , 'add');
        $this->addPermissions('admin' , 'updateComment', null , 'update');
        $this->addPermissions('website' , 'addComment', null , 'add');
        $this->addPermissions('website' , 'updateComment', null , 'update');
        $this->addPermissions('admin' , 'deleteComment' ,  null , 'delete');
        $this->addPermissions('website' , 'deleteComment',  null , 'delete');
    }

    protected function addPermissions($type = 'admin' , $method = 'addComment' , $overriderAdminOnWebsite = null , $action){
        $overriderAdminOnWebsite = $overriderAdminOnWebsite == null ? $type  : $overriderAdminOnWebsite;
        $array = [
            'name' => $action.'-comment-'.ucfirst($this->relatedMode).ucfirst($this->getNameInput()),
            'slug' => 'App-Application-Controllers-'.ucfirst($overriderAdminOnWebsite).'-'.ucfirst($this->relatedMode).ucfirst($this->getNameInput()),
            'description' => 'Allow '.$type.' on index in '.ucfirst($this->relatedMode).ucfirst($this->getNameInput()).' Controller ',
            'controller_name' => ucfirst($this->relatedMode).ucfirst($this->getNameInput()).'Controller',
            'controller_type' => $type,
            'method_name' => $method,
            'permission' => 1,
            'namespace' => 'App\\Application\\Controllers\\'.ucfirst($overriderAdminOnWebsite).'\\'.ucfirst($this->relatedMode).ucfirst($this->getNameInput()).'Controller'
        ];
        $item = Permission::create($array);
        if($type == 'admin'){
            $group = Group::find(1);
            $group->permission()->attach($item);
        }else{
            $group = Group::find(2);
            $group->permission()->attach($item);
            $group = Group::find(1);
            $group->permission()->attach($item);
        }

    }

    protected function addControllerFunction(){
        $name = strtolower($this->relatedMode);
        $path = $this->getPath('Application\\Controllers\\Admin\\'.ucfirst($this->relatedMode).'CommentController');
        $this->files->append($path, $this->adminFunction($name, __DIR__ . '/stub/updateAddCommentAdminFunction.stub'));
        $path = $this->getPath('Application\\Controllers\\Website\\'.ucfirst($this->relatedMode).'CommentController');
        $this->files->append($path, $this->adminFunction($name, __DIR__ . '/stub/updateAddCommentWebsiteFunction.stub'));
    }

    protected function adminFunction($name, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DummySmall', $name)
            ->replace($stub, 'DummyParent', ucfirst($name))
            ->replaceView($stub, 'Dummy', ucfirst($name).'Comment');
    }

    protected function createFolders()
    {
        $this->createFolder('Application/views/admin/' . $this->relatedMode . '/comment');
        $this->createFolder('Application/views/website/' . $this->relatedMode . '/comment');
    }
    protected function route()
    {
        $name = strtolower($this->relatedMode);
        $path = $this->getPath('Application\\routes\\appendWebsite');
        $this->files->append($path, $this->websiteRoute($name, __DIR__ . '/stub/commentWebsite.stub'));
        $path = $this->getPath('Application\\routes\\admin');
        $this->files->append($path, $this->websiteRoute($name, __DIR__ . '/stub/commentWebsite.stub'));
    }

    protected function websiteRoute($name, $stub)
    {
        $stub = $this->files->get($stub);
        return $this->replace($stub, 'DummyRoute', $name)
            ->replaceView($stub, 'Dummy', ucfirst($name).'Comment');
    }


    public function addFrom()
    {
        $findAdminEditFile = "</form>" . "\n";
        $adminEdit = app_path('Application/views/admin/' . $this->relatedMode . '/edit.blade.php');
        $this->addLineToFile($adminEdit, $findAdminEditFile, '@include("admin.' . $this->relatedMode . '.comment.edit")' . "\n");
        $this->createFile('Application/views/admin/' . $this->relatedMode . '/comment/edit.blade.php', $this->formGenerator('admin'));
        $adminEdit = app_path('Application/views/website/' . $this->relatedMode . '/edit.blade.php');
        $this->addLineToFile($adminEdit, $findAdminEditFile, '@include("website.' . $this->relatedMode . '.comment.edit")' . "\n");
        $this->createFile('Application/views/website/' . $this->relatedMode . '/comment/edit.blade.php', $this->formGenerator('website'));
        $findAdminEditFile = "</table>" . "\n";
        $adminEdit = app_path('Application/views/admin/' . $this->relatedMode . '/show.blade.php');
        $this->addLineToFile($adminEdit, $findAdminEditFile, '@include("admin.' . $this->relatedMode . '.comment.edit")' . "\n");
        $adminEdit = app_path('Application/views/website/' . $this->relatedMode . '/show.blade.php');
        $this->addLineToFile($adminEdit, $findAdminEditFile, '@include("website.' . $this->relatedMode . '.comment.edit")' . "\n");
    }

    public function addTR()
    {
        $findAdminEditFile = "</table>" . "\n";
        $adminEdit = app_path('Application/views/admin/' . $this->relatedMode . '/show.blade.php');
        $this->addLineToFile($adminEdit, $findAdminEditFile, '@include("admin.' . $this->relatedMode . '.comment.show")' . "\n");
        $this->createFile('Application/views/admin/' . $this->relatedMode . '/comment/show.blade.php', $this->trGenerator("admin"));

        $adminEdit = app_path('Application/views/website/' . $this->relatedMode . '/show.blade.php');
        $this->addLineToFile($adminEdit, $findAdminEditFile, '@include("website.' . $this->relatedMode . '.comment.show")' . "\n");
        $this->createFile('Application/views/website/' . $this->relatedMode . '/comment/show.blade.php', $this->trGenerator("website"));
    }

    public function trGenerator($admin = "admin"){
//        $out = "\t\t".'@php $comments = \App\Application\Model\\'.ucfirst($this->relatedMode).$this->getNameInput().'::with("user")->paginate(env("PAGINATE")); @endphp'."\n";
        $out = "\t\t".'@php $comments = \App\Application\Model\\'.ucfirst($this->relatedMode).$this->getNameInput().'::where("'.$this->relatedMode.'_id" ,$item->id )->with("user")->get(); @endphp'."\n";
        $out .= "\t\t\t".'<h3>{{ trans( "admin.Comments") }} ({{ count($comments) }})</h3>'."\n";
        $out .= "\t\t".'@if(count($comments) > 0)'."\n";
        $out .= "\t\t".'<ol>'."\n";
        $out .= "\t\t".'@foreach($comments as $comment)'."\n";
        $out .= "\t\t\t".'<li>'."\n";
        $out .= "\t\t\t\t".'<div>'."\n";
        $out .= "\t\t\t\t\t".'<span>{{ $comment->user->name}}</span>'."\n";
        $out .= "\t\t\t\t\t".'<span>{{ $comment->created_at}}</span>'."\n";
        $out .= "\t\t\t\t\t".'<p>{{ $comment->comment}}</p>'."\n";
        $out .= '@if(auth()->check() && $comment->user_id == auth()->user()->id)';
        $admin = $admin == 'admin' ? 'admin/' : '';
        $out .= "\t\t\t" . '<a href="{{concatenateLangToUrl("'.$admin. $this->relatedMode . '/delete/comment/".$comment->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>' . "\n";
        $out .= "\t\t\t" . '<span class="btn btn-info" onclick="$(this).next().slideToggle()"><i class="fa fa-edit"></i></span>' . "\n";
        $out .= "\t" . '<form method="post" action="{{ concatenateLangToUrl("'.$admin. $this->relatedMode . '/update/comment/".$comment->id) }}" style="display:none">';
        $out .= "\t" . '{{ csrf_field() }}' . "\n";
        $out .= "\t\t" . '<div class="form-group">' . "\n";
        $out .= "\t\t\t" . '<label for="comment">{{ trans( "admin.Comment") }}</label>' . "\n";
        $out .= "\t\t\t" . '<textarea name="comment" id="comment" rows="8" class="form-control">{{ $comment->comment }}</textarea>' . "\n";
        $out .= "\t\t" . '</div>' . "\n";
        $out .= "\t\t" . '<div class="form-group">' . "\n";
        $out .= "\t\t\t" . '<button type="submit" class="btn btn-info">{{ trans( "admin.Update Comment") }}</button>' . "\n";
        $out .= "\t\t" . '</div>' . "\n";
        $out .= "\t" . '</form>' . "\n";
        $out .= '@endif';
        $out .= "\t\t".'{!! !$loop->last ? "<hr>"  : ""   !!} '."\n";
        $out .= "\t\t\t\t".'</div>'."\n";
        $out .= "\t\t\t".'</li>'."\n";
        $out .= "\t\t".'@endforeach'."\n";
        $out .= "\t\t".'</ol>'."\n";
//        $out .= "\t\t".'{{ $comments->links() }}'."\n";
        $out .= "\t\t".'@endif'."\n";
        return $out;
    }



    public function formGenerator($admin)
    {
        $admin = $admin == 'admin' ? 'admin/' : '';
        $out = '@if(isset($item) && auth()->check())';
        $out .= "\t" . '<form method="post" action="{{ concatenateLangToUrl("'.$admin. $this->relatedMode . '/add/comment/".$item->id) }}">{{ csrf_field() }}' . "\n";
        $out .= "\t\t" . '<div class="form-group">' . "\n";
        $out .= "\t\t\t" . '<label for="comment">{{ trans( "admin.Comment") }}</label>' . "\n";
        $out .= "\t\t\t" . '<textarea name="comment" id="comment" rows="8" class="form-control"></textarea>' . "\n";
        $out .= "\t\t" . '</div>' . "\n";
        $out .= "\t\t" . '<div class="form-group">' . "\n";
        $out .= "\t\t\t" . '<button type="submit" class="btn btn-info">{{ trans( "admin.Add Comment") }}</button>' . "\n";
        $out .= "\t\t" . '</div>' . "\n";
        $out .= "\t" . '</form>' . "\n";
        $out .= '@endif';
        return $out;
    }

    public function cols()
    {
        if ($this->option('cols')) {
            $cols = $this->option('cols');
            $sendCols = explode(',', $cols);
            $this->relatedMode = $sendCols[0];
            $colsToModel = isset($sendCols[1]) ? $sendCols[1] : '';
            if (Schema::hasTable($this->relatedMode . 'comment')) {
                Schema::disableForeignKeyConstraints();
                Schema::drop($this->relatedMode . 'comment');
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
        return ',user_id:integer::false,' . $this->relatedMode . '_id:integer::false,comment:text:min-10_required:false';
    }


    protected function addRelationsOtM()
    {
        $string = 'public $table = "' . $this->relatedMode . '";' . "\n";
        $string1 = 'public $table = "' . $this->relatedMode . strtolower($this->getNameInput()) . '";' . "\n";
        $modelnameP = app_path("Application/Model/" . ucfirst($this->relatedMode) . '.php');
        $modelnameF = app_path("Application/Model/" . ucfirst($this->relatedMode) . $this->getNameInput() . '.php');
        $this->addLineToFile($modelnameP, $string, $this->hasMany(ucfirst($this->relatedMode) . $this->getNameInput(), $this->relatedMode . '_id', $this->relatedMode . strtolower($this->getNameInput())));
        $this->addLineToFile($modelnameF, $string1, $this->belongsTo(ucfirst($this->relatedMode), $this->relatedMode . '_id', $this->relatedMode));
        $this->addLineToFile($modelnameF, $string1, $this->belongsTo("User",  'user_id', "user"));
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
            ['cols', 'c', InputArgument::OPTIONAL, 'Create Comment model']
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
