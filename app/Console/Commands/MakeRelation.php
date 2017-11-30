<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Input\InputArgument;


class MakeRelation extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'laraflat:relation';

    protected $colsMigration = [];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create  Relation ';

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
            }elseif ($key == 4) {
                $this->pluckFone = $col;
            }elseif ($key == 5) {
                $this->pluckFtwo = $col;
            }elseif ($key == 6) {
                $this->pluckPOne = $col;
            }elseif ($key == 7) {
                $this->typeMtm = $col;
            }
        }

        if ($this->type == 'otm') {
            $this->otm();
        } elseif ($this->type == 'mtm') {
            $this->mtm();
        } elseif ($this->type == 'oto') {
            $this->oto();
        }
    }

    protected function getOptions()
    {
        return [
            ['options', 'c', InputArgument::OPTIONAL, 'Generate Relation']
        ];
    }

    protected function getStub()
    {

    }

    protected function mtm(){
        $this->createRelationFolder();
        $this->mtmMigration();
        $this->addRelationsMtM();
        $this->adminMtmHtml();
        $this->websiteMtmHtml();
        $this->addSaveToControllers();
        $this->addToViews();
    }

    protected function addToViews(){
        $findAdminShowFile = '<table class="table table-bordered table-responsive table-striped">'."\n";
        $template = app_path('Application/views/website/'.$this->fKey.'/show.blade.php');
        $this->addLineToFile($template , $findAdminShowFile , '@include("website.'.$this->fKey.'.relation.'.$this->pKey.'.show")'."\n");
        $this->createFile('Application/views/website/'.$this->fKey.'/relation/'.$this->pKey.'/show.blade.php',$this->getAdminTr($this->pKey , $this->fKey , $this->pluckFone , false));

        $template = app_path('Application/views/admin/'.$this->fKey.'/show.blade.php');
        $this->addLineToFile($template , $findAdminShowFile , '@include("admin.'.$this->fKey.'.relation.'.$this->pKey.'.show")'."\n");
        $this->createFile('Application/views/admin/'.$this->fKey.'/relation/'.$this->pKey.'/show.blade.php',$this->getAdminTr($this->pKey , $this->fKey , $this->pluckFone));

        $template = app_path('Application/views/website/'.$this->pKey.'/show.blade.php');
        $this->addLineToFile($template , $findAdminShowFile , '@include("website.'.$this->pKey.'.relation.'.$this->fKey.'.show")'."\n");
        $this->createFile('Application/views/website/'.$this->pKey.'/relation/'.$this->fKey.'/show.blade.php',$this->getAdminTr($this->fKey , $this->pKey , $this->pluckPOne , false));

        $template = app_path('Application/views/admin/'.$this->pKey.'/show.blade.php');
        $this->addLineToFile($template , $findAdminShowFile , '@include("admin.'.$this->pKey.'.relation.'.$this->fKey.'.show")'."\n");
        $this->createFile('Application/views/admin/'.$this->pKey.'/relation/'.$this->fKey.'/show.blade.php',$this->getAdminTr($this->fKey , $this->pKey , $this->pluckFone));
    }

    protected function getAdminTr($key , $okey , $p , $admin = true){
        $out = "\t\t".'<tr>'."\n";
        $out .= "\t\t\t".'<th>'."\n";
        $out .= "\t\t\t".'{{ trans( "'.$key.'.'.$key.'") }}'."\n";
        $out .= "\t\t\t".'</th>'."\n";
        $out .= "\t\t\t".'<td>'."\n";
        $out .= "\t\t".'<div class="form-group"><ol>'."\n";

        $out .= "\t\t\t".'@php  $'.str_plural($key).' = $item->'.$key.' ? $item->'.$key.'->pluck("'.$p.'" ,"id")->all() : [] @endphp'."\n";
        $out .= "\t\t\t".'@foreach( $'.str_plural($key).' as $key => $relatedItem)'."\n";
        $out .= "\t\t".'<li>'."\n";
        $url = $admin == true ? '/admin/' : '/';
        $out .= "\t\t".'<a href="'.$url.$key.'/item/{{ $key }}">{{ is_json($relatedItem) ? getDefaultValueKey($relatedItem) :  $relatedItem}}</a>'."\n";
        $out .= "\t\t".'</li>'."\n";
        $out .= "\t\t\t".'@endforeach'."\n";
        $out .= "\t\t".'</ol></div>'."\n";

        $out .= "\t\t\t".'</td>'."\n";
        $out .= "\t\t".'</tr>'."\n";
        return $out;
    }

    protected function adminMtmHtml(){
        $findAdminEditFile = "{{ csrf_field() }}"."\n";
        $adminEdit = app_path('Application/views/admin/'.$this->fKey.'/edit.blade.php');
        $this->addLineToFile($adminEdit , $findAdminEditFile , '@include("admin.'.$this->fKey.'.relation.'.$this->pKey.'.edit")'."\n");
        if($this->typeMtm == 'select'){
            $this->createFile('Application/views/admin/'.$this->fKey.'/relation/'.$this->pKey.'/edit.blade.php',$this->addSelectMtM($this->pKey));
        }else{
            $this->createFile('Application/views/admin/'.$this->fKey.'/relation/'.$this->pKey.'/edit.blade.php',$this->addCheckBox($this->pKey));
        }
        $adminEdit = app_path('Application/views/admin/'.$this->pKey.'/edit.blade.php');
        $this->addLineToFile($adminEdit , $findAdminEditFile , '@include("admin.'.$this->pKey.'.relation.'.$this->fKey.'.edit")'."\n");
        $this->createFile('Application/views/admin/'.$this->pKey.'/relation/'.$this->fKey.'/edit.blade.php',$this->showTr($this->pKey , $this->fKey));
    }

    protected function websiteMtmHtml(){
        $findAdminEditFile = "{{ csrf_field() }}"."\n";
        $adminEdit = app_path('Application/views/website/'.$this->fKey.'/edit.blade.php');
        $this->addLineToFile($adminEdit , $findAdminEditFile , '@include("website.'.$this->fKey.'.relation.'.$this->pKey.'.edit")'."\n");
        if($this->typeMtm == 'select'){
            $this->createFile('Application/views/website/'.$this->fKey.'/relation/'.$this->pKey.'/edit.blade.php',$this->addSelectMtM($this->pKey));
        }else{
            $this->createFile('Application/views/website/'.$this->fKey.'/relation/'.$this->pKey.'/edit.blade.php',$this->addCheckBox($this->pKey));
        }
        $adminEdit = app_path('Application/views/website/'.$this->pKey.'/edit.blade.php');
        $this->addLineToFile($adminEdit , $findAdminEditFile , '@include("website.'.$this->pKey.'.relation.'.$this->fKey.'.edit")'."\n");
        $this->createFile('Application/views/website/'.$this->pKey.'/relation/'.$this->fKey.'/edit.blade.php',$this->showTr($this->pKey , $this->fKey , false));
    }

    protected function addSaveToControllers(){
        ///admin
        $findAdminEditFile = '$item =  $this->storeOrUpdate($request , null , true);'."\n";
        $adminEdit = app_path('Application/Controllers/Admin/'.ucfirst($this->fKey).'Controller.php');
        $this->addLineToFile($adminEdit , $findAdminEditFile , $this->addController($this->pKey , $this->fKey));
        $findAdminEditFile = '$item =  $this->storeOrUpdate($request , $id , true);'."\n";
        $this->addLineToFile($adminEdit , $findAdminEditFile , $this->addController($this->pKey , $this->fKey));
        ////website
        $findwebsiteEditFile = '$item =  $this->storeOrUpdate($request , null , true);'."\n";
        $websiteEdit = app_path('Application/Controllers/Website/'.ucfirst($this->fKey).'Controller.php');
        $this->addLineToFile($websiteEdit , $findwebsiteEditFile , $this->addController($this->pKey , $this->fKey));
        $findwebsiteEditFile = '$item =  $this->storeOrUpdate($request , $id , true);'."\n";
        $this->addLineToFile($websiteEdit , $findwebsiteEditFile , $this->addController($this->pKey , $this->fKey));
    }

    protected function addController( $oKey , $key){
        $out = "\t\t".'if(count($request->'.$oKey.'_id) > 0){'."\n";
        $out .= "\t\t\t".'$item->'.$oKey.'()->sync($request->'.$oKey.'_id);'."\n";
        $out .= "\t\t".'}'."\n";
        return $out;
    }

    protected function showTr($key , $oKey , $admin = true){
        $out = "\t\t".'@if(isset($item))'."\n";
        $out .= "\t\t".'<div class="form-group"><ol>'."\n";
        $out .= "\t\t\t".'@php  $'.str_plural($oKey).' = $item->'.$oKey.' ? $item->'.$oKey.'->pluck("'.$this->pluckPOne.'" ,"id")->all() : [] @endphp'."\n";
        $out .= "\t\t\t".'@foreach( $'.str_plural($oKey).' as $key => $relatedItem)'."\n";
        $out .= "\t\t".'<li class="col-lg-2">'."\n";
        $admin = $admin == true ? '/admin/' : '/';
        $out .= "\t\t".'<a href="'.$admin.$oKey.'/item/{{ $key }}">{{ is_json($relatedItem) ? getDefaultValueKey($relatedItem) :  $relatedItem}}</a>'."\n";
        $out .= "\t\t".'</li>'."\n";
        $out .= "\t\t\t".'@endforeach'."\n";
        $out .= "\t\t".'</ol></div>'."\n";
        $out .= "\t\t".'@endif'."\n";
        return $out;

    }

    protected function addSelectMtM($key){
        $out = "\t\t".'<div class="form-group">'."\n";
        $out .= "\t\t\t".'<label for="'.$key.'">{{ trans( "'.$key.'.'.$key.'") }}</label>'."\n";
        $out .= "\t\t\t".'@php $'.str_plural($key).' = App\\Application\\Model\\'.ucfirst($key).'::pluck("'.$this->pluckFone.'" ,"'.$this->pluckFtwo.'")->all()  @endphp'."\n";
        $out .= "\t\t\t".'@php  $'.$key.'_id = isset($item) ? $item->'.$this->pKey.'->pluck("id")->all() : [] @endphp'."\n";
        $out .= "\t\t\t".'<select name="'.$key.'_id[]"  class="form-control" multiple>'."\n";
        $out .= "\t\t\t".'@foreach( $'.str_plural($key).' as $key => $relatedItem)'."\n";
        $out .= "\t\t\t".'<option value="{{ $key }}"  {{ in_array($key ,$'.$key.'_id ) ? "selected" : "" }}> {{ is_json($relatedItem) ? getDefaultValueKey($relatedItem) :  $relatedItem}}</label>'."\n";
        $out .= "\t\t\t".'@endforeach'."\n";
        $out .= "\t\t\t".'</select>'."\n";
        $out .= "\t\t".'</div>'."\n";
        return $out;
    }

    protected function addCheckBox($key){
        $out = "\t\t".'<div class="form-group">'."\n";
        $out .= "\t\t\t".'<label for="'.$key.'">{{ trans( "'.$key.'.'.$key.'") }}</label><br>'."\n";
        $out .= "\t\t\t".'@php $'.str_plural($key).' = App\\Application\\Model\\'.ucfirst($key).'::pluck("'.$this->pluckFone.'" , "'.$this->pluckFtwo.'")->all()  @endphp'."\n";
        $out .= "\t\t\t".'@php  $'.$key.'_id = isset($item) ? $item->'.$this->pKey.'->pluck("id")->all() : [] @endphp'."\n";
        $out .= "\t\t\t".'@foreach( $'.str_plural($key).' as $key => $relatedItem)'."\n";
        $out .= "\t\t\t".'<input name="'.$key.'_id[]" type="checkbox" value="{{ $key }}" {{ in_array($key ,$'.$key.'_id ) ? "checked" : "" }} />'."\n";
        $out .= "\t\t\t".'<label> {{ is_json($relatedItem) ? getDefaultValueKey($relatedItem) :  $relatedItem}}</label>'."\n";
        $out .= "\t\t\t".'@endforeach'."\n";
        $out .= "\t\t".'</div>'."\n";
        return $out;
    }

    protected function addRelationsMtM(){
        if($this->pKey == 'user'){
            $key = 'users';
        }else{
            $key = $this->pKey;
        }
        $string = 'public $table = "'.$key.'";'."\n";
        $string1 = 'public $table = "'.$this->fKey.'";'."\n";
        $modelnameP = app_path("Application/Model/" . ucfirst($this->pKey).'.php');
        $modelnameF = app_path("Application/Model/" . ucfirst($this->fKey).'.php');
        $this->addLineToFile($modelnameP , $string , $this->belongsToMany(ucfirst($this->fKey) , $this->pKey.'_'.$this->fKey , $this->fKey , $this->pKey.'_id' , $this->fKey.'_id' ));
        $this->addLineToFile($modelnameF , $string1 , $this->belongsToMany(ucfirst($this->pKey) , $this->pKey.'_'.$this->fKey , $this->pKey  , $this->fKey.'_id', $this->pKey.'_id' ));
    }

    protected function mtmMigration(){
        $tableName = "App\\Application\\Model\\" . ucfirst($this->pKey);
        $Pmodel = new $tableName();
        $pt = $Pmodel->getTable();
        $tableName = "App\\Application\\Model\\" . ucfirst($this->fKey);
        $fmodel = new $tableName();
        $ft = $fmodel->getTable();
        $fKey = ($fmodel->primaryKey) ? $fmodel->primaryKey : 'id';
        $pkey = ($Pmodel->primaryKey) ? $Pmodel->primaryKey : 'id';
        $fk = $this->fk;
        if (Schema::hasTable($pt.'_'.$ft)) {
            Schema::disableForeignKeyConstraints();
            Schema::drop($pt.'_'.$ft);
            Schema::enableForeignKeyConstraints();
        }
        Schema::create($pt.'_'.$ft, function (Blueprint $table) use ($ft, $pt , $pkey , $fKey , $fk) {
            $table->increments('id');
            Schema::disableForeignKeyConstraints();
            $table->integer($ft . '_id')->unsigned();
            $table->integer($pt . '_id')->unsigned();
            if ($fk === 'true') {
                $table->foreign($ft . '_id')->references($fKey)->on($ft)->onDelete('cascade');
                $table->foreign($pt . '_id')->references($pkey)->on($pt)->onDelete('cascade');
            }
            Schema::enableForeignKeyConstraints();
            $table->timestamps();
        });
        Artisan::call("migrate");
    }

    protected function oto(){
        $this->createRelationFolder();
        $this->addHtml();
        $this->makeMigration();
        $this->makeValidation();
        $this->addRelationsOtO();
    }

    protected function otm()
    {
        $this->createRelationFolder();
        $this->addHtml();
        $this->makeMigration();
        $this->makeValidation();
        $this->addRelationsOtM();
    }

    protected function createRelationFolder(){

        $this->createFolder('Application/views/admin/'.$this->pKey.'/relation');
        $this->createFolder('Application/views/admin/'.$this->fKey.'/relation');
        $this->createFolder('Application/views/website/'.$this->pKey.'/relation');
        $this->createFolder('Application/views/website/'.$this->fKey.'/relation');
        $this->createFolder('Application/views/admin/'.$this->fKey.'/relation/'.$this->pKey);
        $this->createFolder('Application/views/admin/'.$this->pKey.'/relation/'.$this->fKey);
        $this->createFolder('Application/views/website/'.$this->pKey.'/relation/'.$this->fKey);
        $this->createFolder('Application/views/website/'.$this->fKey.'/relation/'.$this->pKey);
    }

    protected function addRelationsOtO(){
        if($this->pKey == 'user'){
            $key = 'users';
        }else{
            $key = $this->pKey;
        }
        $string = 'public $table = "'.$key.'";'."\n";
        $string1 = 'public $table = "'.$this->fKey.'";'."\n";
        $modelnameP = app_path("Application/Model/" . ucfirst($this->pKey).'.php');
        $modelnameF = app_path("Application/Model/" . ucfirst($this->fKey).'.php');
        $this->addLineToFile($modelnameP , $string , $this->hasOne(ucfirst($this->fKey) , $this->pKey.'_id' , $this->fKey));
        $this->addLineToFile($modelnameF , $string1 , $this->belongsTo(ucfirst($this->pKey) , $this->pKey.'_id' , $this->pKey));
    }

    protected function addRelationsOtM(){
        if($this->pKey == 'user'){
            $key = 'users';
        }else{
            $key = $this->pKey;
        }
        $string = 'public $table = "'.$key.'";'."\n";
        $string1 = 'public $table = "'.$this->fKey.'";'."\n";
        $modelnameP = app_path("Application/Model/" . ucfirst($this->pKey).'.php');
        $modelnameF = app_path("Application/Model/" . ucfirst($this->fKey).'.php');
        $this->addLineToFile($modelnameP , $string , $this->hasMany(ucfirst($this->fKey) , $this->pKey.'_id' , $this->fKey));
        $this->addLineToFile($modelnameF , $string1 , $this->belongsTo(ucfirst($this->pKey) , $this->pKey.'_id' , $this->pKey));
    }

    protected function hasOne($model , $col , $name){
        $out = "public function ".$name."(){"."\n";
        $out .= "\t\t".'return $this->hasOne('.$model.'::class, "'.$col.'");'."\n";
        $out .=  "\t\t"."}"."\n";
        return $out;
    }

    protected function hasMany($model , $col , $name){
        $out = "public function ".$name."(){"."\n";
        $out .= "\t\t".'return $this->hasMany('.$model.'::class, "'.$col.'");'."\n";
        $out .=  "\t\t"."}"."\n";
        return $out;
    }

    protected function belongsTo($model , $col , $name){
        $out = "public function ".$name."(){"."\n";
        $out .= "\t\t".'return $this->belongsTo('.$model.'::class, "'.$col.'");'."\n";
        $out .=  "\t\t"."}"."\n";
        return $out;
    }

    protected function belongsToMany($model , $table  , $name , $col , $col2){
        $out = "public function ".$name."(){"."\n";
        $out .= "\t\t".'return $this->belongsToMany( '.$model.'::class, "'.$table.'", "'.$col.'" , "'.$col2.'");'."\n";
        $out .=  "\t\t"."}"."\n";
        return $out;
    }

    protected function makeValidation(){
        $string = "return ["."\n";
        $adminAddValidation = app_path('Application/Requests/Admin/'.ucfirst($this->fKey).'/AddRequest'.ucfirst($this->fKey).'.php');
        $adminUpdateValidation = app_path('Application/Requests/Admin/'.ucfirst($this->fKey).'/UpdateRequest'.ucfirst($this->fKey).'.php');
        $websiteUpdateValidation = app_path('Application/Requests/Website/'.ucfirst($this->fKey).'/UpdateRequest'.ucfirst($this->fKey).'.php');
        $websiteAddValidation = app_path('Application/Requests/Website/'.ucfirst($this->fKey).'/AddRequest'.ucfirst($this->fKey).'.php');
        $ApiUpdateValidation = app_path('Application/Requests/Website/'.ucfirst($this->fKey).'/ApiUpdateRequest'.ucfirst($this->fKey).'.php');
        $ApiAddValidation = app_path('Application/Requests/Website/'.ucfirst($this->fKey).'/ApiAddRequest'.ucfirst($this->fKey).'.php');
        $this->addLineToFile($adminAddValidation , $string , "\t".'"'.$this->pKey.'_id" => "required|integer",'."\n");
        $this->addLineToFile($adminUpdateValidation , $string , "\t".'"'.$this->pKey.'_id" => "required|integer",'."\n");
        $this->addLineToFile($websiteUpdateValidation , $string , "\t".'"'.$this->pKey.'_id" => "required|integer",'."\n");
        $this->addLineToFile($websiteAddValidation , $string , "\t".'"'.$this->pKey.'_id" => "required|integer",'."\n");
        $this->addLineToFile($ApiUpdateValidation , $string , "\t".'"'.$this->pKey.'_id" => "required|integer",'."\n");
        $this->addLineToFile($ApiAddValidation , $string , "\t".'"'.$this->pKey.'_id" => "required|integer",'."\n");
    }

    public function addHtml()
    {
        //////adminEdit
        $findAdminEditFile = "{{ csrf_field() }}"."\n";
        $adminEdit = app_path('Application/views/admin/'.$this->fKey.'/edit.blade.php');
        $this->addLineToFile($adminEdit , $findAdminEditFile , '@include("admin.'.$this->fKey.'.relation.'.$this->pKey.'.edit")'."\n");
        $this->createFile('Application/views/admin/'.$this->fKey.'/relation/'.$this->pKey.'/edit.blade.php',$this->selectHtml());
        $websiteEdit = app_path('Application/views/website/'.$this->fKey.'/edit.blade.php');
        $this->addLineToFile($websiteEdit , $findAdminEditFile , '@include("website.'.$this->fKey.'.relation.'.$this->pKey.'.edit")'."\n");
        $this->createFile('Application/views/website/'.$this->fKey.'/relation/'.$this->pKey.'/edit.blade.php',$this->selectHtml());
        //////admin view
        $findAdminShowFile = '<table class="table table-bordered table-responsive table-striped">'."\n";
        $adminView = app_path('Application/views/admin/'.$this->fKey.'/show.blade.php');
        $this->addLineToFile($adminView , $findAdminShowFile , '@include("admin.'.$this->fKey.'.relation.'.$this->pKey.'.show")'."\n");
        $this->createFile('Application/views/admin/'.$this->fKey.'/relation/'.$this->pKey.'/show.blade.php', $this->getTr());
        $websiteView = app_path('Application/views/website/'.$this->fKey.'/show.blade.php');
        $this->addLineToFile($websiteView , $findAdminShowFile , '@include("website.'.$this->fKey.'.relation.'.$this->pKey.'.show")'."\n");
        $this->createFile('Application/views/website/'.$this->fKey.'/relation/'.$this->pKey.'/show.blade.php', $this->getTr());

        ///////model
        $model = app_path('Application/Model/'.ucfirst($this->fKey).'.php');
        $findModel = 'protected $fillable = ['."\n";
        $this->addLineToFile($model , $findModel , "'".$this->pKey."_id',"."\n");
    }

    protected function getTr(){
        $out = "\t\t".'<tr>'."\n";
        $out .= "\t\t\t".'<th>'."\n";
        $out .= "\t\t\t".'{{ trans( "'.$this->pKey.'.'.$this->pKey.'") }}'."\n";
        $out .= "\t\t\t".'</th>'."\n";
        $out .= "\t\t\t".'<td>'."\n";
        $out .= "\t\t\t\t".'@php $'.$this->pKey.' = App\\Application\\Model\\'.ucfirst($this->pKey).'::find($item->'.$this->pKey.'_id);  @endphp'."\n";
        $out .= "\t\t\t\t".'{{ is_json($'.$this->pKey.'->'.$this->pluckFone.') ? getDefaultValueKey($'.$this->pKey.'->'.$this->pluckFone.') :  $'.$this->pKey.'->'.$this->pluckFone.'}}'."\n";
        $out .= "\t\t\t".'</td>'."\n";
        $out .= "\t\t".'</tr>'."\n";
        return $out;
    }

    protected function selectHtml(){
        $out = "\t\t".'<div class="form-group">'."\n";
        $out .= "\t\t\t".'<label for="'.$this->pKey.'">{{ trans( "'.$this->pKey.'.'.$this->pKey.'") }}</label>'."\n";
        $out .= "\t\t\t".'@php $'.str_plural($this->pKey).' = App\\Application\\Model\\'.ucfirst($this->pKey).'::pluck("'.$this->pluckFone.'" ,"'.$this->pluckFtwo.'")->all()  @endphp'."\n";
        $out .= "\t\t\t".'@php  $'.$this->pKey.'_id = isset($item) ? $item->'.$this->pKey.'_id : null @endphp'."\n";
        $out .= "\t\t\t".'<select name="'.$this->pKey.'_id"  class="form-control" >'."\n";
        $out .= "\t\t\t".'@foreach( $'.str_plural($this->pKey).' as $key => $relatedItem)'."\n";
        $out .= "\t\t\t".'<option value="{{ $key }}"  {{ $key == $'.$this->pKey.'_id  ? "selected" : "" }}> {{ is_json($relatedItem) ? getDefaultValueKey($relatedItem) :  $relatedItem}}</label>'."\n";
        $out .= "\t\t\t".'@endforeach'."\n";
        $out .= "\t\t\t".'</select>'."\n";
        $out .= "\t\t".'</div>'."\n";
        return $out;
    }

    protected function makeMigration()
    {
        $tableName = "App\\Application\\Model\\" . ucfirst($this->pKey);
        $Pmodel = new $tableName();
        $pt = $Pmodel->getTable();
        $tableName = "App\\Application\\Model\\" . ucfirst($this->fKey);
        $fmodel = new $tableName();
        $ft = $fmodel->getTable();
        $key = ($fmodel->primaryKey) ? $fmodel->primaryKey : 'id';
        $fk = $this->fk;
        $pk = $this->pKey;
        Schema::disableForeignKeyConstraints();
        DB::table($ft)->truncate();
        Schema::enableForeignKeyConstraints();
        if (Schema::hasColumn($ft, $pk.'_id'))
        {
            $arrayOfKeys = $this->listTableForeignKeys($ft);
            Schema::table($ft, function ($table) use ($pk , $ft , $arrayOfKeys) {
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
        Schema::table($ft, function (Blueprint $table) use ($key, $pk, $fk, $pt) {
            $table->integer($pk . '_id')->unsigned();
            if ($fk === 'true') {
                $table->foreign($pk . '_id')->references($key)->on($pt)->onDelete('cascade');
            }
        });
        Artisan::call("migrate");
    }

    public function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();
        return array_map(function($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }

    protected function addLineToFile($src , $text , $append){
        $fc=file($src);
        $f=fopen($src,"w");
        foreach($fc as $line)
        {
            $out = '';
            $tabs = strlen($line) - strlen(ltrim($line));
            for($i = 0; $i < $tabs ;$i++){
                $out .= ' ';
            }
            $line =  ltrim($line);
            if (!strstr($line,$text)){
                fputs($f,$out.$line); //place $line back in file
            }else{
                fputs($f,$out.$line);
                fputs($f , $out.$append);
            }
        }
        fclose($f);
    }

    protected function replaceLine($src , $text , $append){
        $fc=file($src);
        $f=fopen($src,"w");
        foreach($fc as $line)
        {
            $out = '';
            $tabs = strlen($line) - strlen(ltrim($line));
            for($i = 0; $i < $tabs ;$i++){
                $out .= ' ';
            }
            $line =  ltrim($line);
            if (!strstr($line,$text)){
                fputs($f,$out.$line); //place $line back in file
            }else{
                fputs($f , $out.$append);
            }
        }
        fclose($f);
    }

    protected function createFolder($path){
        try{
            if(!file_exists($path)) {
                File::makeDirectory(app_path($path), 0775, true, true);
            }
        }catch(\Exception $e){

        }

    }

    protected function createFile($path , $content){
        if(!file_exists(app_path($path))){
            File::put(app_path($path) , $content , 0775);
        }
    }

    protected function deleteFile($path){
        if(!file_exists(app_path($path))) {
            File::delete(app_path($path));
        }
    }

}
