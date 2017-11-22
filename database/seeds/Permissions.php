<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();
         $keyType = "admin";
            foreach(getControllerByType($keyType , 'array') as $keryController => $controller){
                foreach(getMethodByController($keryController ,$keyType , 'array' ) as $methodKey => $method){
                    if($method != "__construct"){
                        $array = [
                            'name' => "$method-$controller",
                            'slug' => ltrim($keryController , '-').'-'.$method,
                            'description' => "Allow $keyType on $method in controller $controller",
                            'controller_name' => $controller,
                            'method_name' => $method,
                            'controller_type' => $keyType,
                            'namespace' => ltrim(str_replace('-' , '\\' , $keryController) , '\\'),
                            'permission' => 1
                        ];
                        \App\Application\Model\Permission::create($array);
                    }
                }
            }
        }

}
