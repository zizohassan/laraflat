<?php

use Illuminate\Database\Seeder;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'User',
            'slug'=> 'user',
            'description'=> 'Full Access to all user model',
            'model'=> 'user',
            'action_add'=> 'on',
            'action_edit'=>  'on',
            'action_delete'=>  'on',
            'action_view'=>  'on',
        ]);
        DB::table('permissions')->insert([
            'name' => 'Group',
            'slug'=> 'group',
            'description'=> 'Full Access to all group model',
            'model'=> 'group',
            'action_add'=> 'on',
            'action_edit'=>  'on',
            'action_delete'=>  'on',
            'action_view'=>  'on',
        ]);
        DB::table('permissions')->insert([
            'name' => 'Role',
            'slug'=> 'role',
            'description'=> 'Full Access to all user Role',
            'model'=> 'role',
            'action_add'=> 'on',
            'action_edit'=>  'on',
            'action_delete'=>  'on',
            'action_view'=>  'on',
        ]);
        DB::table('permissions')->insert([
            'name' => 'Permission',
            'slug'=> 'permission',
            'description'=> 'Full Access to all permission model',
            'model'=> 'permission',
            'action_add'=> 'on',
            'action_edit'=>  'on',
            'action_delete'=>  'on',
            'action_view'=>  'on',
        ]);
    }
}
