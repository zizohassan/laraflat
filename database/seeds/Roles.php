<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('roles')->truncate();
        \Illuminate\Support\Facades\DB::table('permission_role')->truncate();
        \Illuminate\Support\Facades\DB::table('role_user')->truncate();
        Schema::enableForeignKeyConstraints();
        foreach(\App\Application\Model\Permission::get()->groupBy('controller_name') as $key =>  $controllerGroup){
            $array = [
                'name' => "$key",
                'slug' => "$key-admin",
                'description' => "Access to All $key functions"
            ];
           $role =  \App\Application\Model\Role::create($array);
            $role->permission()->sync($controllerGroup->pluck('id')->all());
        }
    }
}
