<?php

use Illuminate\Database\Seeder;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'User',
            'slug'=> 'user',
            'description'=> 'Add , edit , delete , view role to model user',
        ]);

        DB::table('roles')->insert([
            'name' => 'Group',
            'slug'=> 'group',
            'description'=> 'Add , edit , delete , view role to model group',
        ]);

        DB::table('roles')->insert([
            'name' => 'Role',
            'slug'=> 'role',
            'description'=> 'Add , edit , delete , view role to model role',
        ]);

        DB::table('roles')->insert([
            'name' => 'Permission',
            'slug'=> 'permission',
            'description'=> 'Add , edit , delete , view role to model permission',
        ]);

        DB::table('roles')->insert([
            'name' => 'Setting',
            'slug'=> 'setting',
            'description'=> 'Add , edit , delete , view role to model setting',
        ]);
    }
}
