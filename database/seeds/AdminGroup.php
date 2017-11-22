<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AdminGroup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        DB::table('groups')->truncate();
        DB::table('permission_group')->truncate();
        DB::table('group_role')->truncate();
        Schema::enableForeignKeyConstraints();

        $array = [
            'name' => 'Admin',
            'slug'=> 'admin',
            'description'=> 'Access to User , permission , role , groups roles',
        ];
        $group = \App\Application\Model\Group::create($array);

        DB::table('groups')->insert([
            'name' => 'User',
            'slug'=> 'user',
            'description'=> 'User group ',
        ]);

        $rols = \App\Application\Model\Role::pluck('id')->all();
        $group->role()->sync($rols);



    }
}
