<?php
function getAllTables(){
    return \Illuminate\Support\Facades\DB::select('SHOW TABLES');
}

function getModels(){
//    $array  = getListOfFiles(app_path()."/Application/Model");
//    $array = removeFromArray($array , removeNotPermissionTable());
//    return rename_keys($array , $array);
        $array = [];
        $models = \App\Application\Model\Command::where('command' ,'laraflat:admin_model')->plucK('name')->all();
        foreach ($models as $model){
            $array[mb_strtolower($model)] = mb_strtolower($model);
        }
        return $array + appendModelsArray();

//    $array = array_map("getTableName" , getAllTables());
//    $array = removeFromArray($array , removeNotPermissionTable());
//    return rename_keys($array ,$array);
}
function appendModelsArray(){
    return [
       'user' => 'user'
    ];
}
function removeNotPermissionTable(){
    return [
      'item',
       'user_info',
        'command',
        'contact',
        'group',
        'log',
        'permission',
        'relation',
        'role',
        'setting',
        'menu'
    ];
}

function getTableName($item){
    $table = 'Tables_in_'.env('DB_DATABASE');
    return $item->$table;
}

function getListOfFiles($path){
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $filename = strtolower($result);
            if (is_dir($filename)) {
                $out = array_merge($out, getListOfModel($path . '/' . $filename));
            }else{
                $out[] = substr($filename,0,-4);
            }
        }
        return $out;
}
