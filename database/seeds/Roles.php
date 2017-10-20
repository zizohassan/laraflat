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

        DB::table('roles')->insert([
            'name' => 'Menu',
            'slug'=> 'menu',
            'description'=> 'Add , edit , delete , view role to model Menu',
        ]);

        DB::table('roles')->insert([
            'name' => 'Page',
            'slug'=> 'page',
            'description'=> 'Add , edit , delete , view role to model Page',
        ]);

        DB::table('roles')->insert([
            'name' => 'Log',
            'slug'=> 'log',
            'description'=> 'Add , edit , delete , view role to model Log',
        ]);

        DB::table('roles')->insert([
            'name' => 'Categories',
            'slug'=> 'Categories',
            'description'=> 'Add , edit , delete , view role to model Categories',
        ]);
        DB::table('roles')->insert([
            'name' => 'Contact',
            'slug'=> 'Contact',
            'description'=> 'Add , edit , delete , view role to model Contact',
        ]);
    }
}
