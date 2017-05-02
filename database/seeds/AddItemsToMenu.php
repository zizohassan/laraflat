<?php

use Illuminate\Database\Seeder;

class AddItemsToMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('items')->insert([
            'name' => 'Home',
            'link' => '/admin/home',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 1,
            'icon' => '<i class="material-icons">home</i>'
        ]);

        DB::table('items')->insert([
            'name' => 'Users',
            'link' => '/admin/users',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 2,
            'icon' => '<i class="material-icons">account_circle</i>'
        ]);

        DB::table('items')->insert([
            'name' => 'Settings',
            'link' => '/admin/settings',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 3,
            'icon' => '<i class="material-icons">insert_emoticon</i>'
        ]);


        DB::table('items')->insert([
            'name' => 'Pages',
            'link' => '/admin/page',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 4,
            'icon' => '<i class="material-icons">find_in_page</i>'
        ]);



        DB::table('items')->insert([
            'name' => 'User',
            'link' => '/admin/user',
            'type' => '',
            'parent_id' => 2,
            'menu_id' => 1,
            'order' => 1
        ]);



        DB::table('items')->insert([
            'name' => 'Group',
            'link' => '/admin/group',
            'type' => '',
            'parent_id' => 2,
            'menu_id' => 1,
            'order' => 2,
        ]);



        DB::table('items')->insert([
            'name' => 'Role',
            'link' => '/admin/role',
            'type' => '',
            'parent_id' => 2,
            'menu_id' => 1,
            'order' => 3,
        ]);

        DB::table('items')->insert([
            'name' => 'Permission',
            'link' => '/admin/permission',
            'type' => '',
            'parent_id' => 2,
            'menu_id' => 1,
            'order' => 4,
        ]);

        DB::table('items')->insert([
            'name' => 'Icons',
            'link' => '/admin/icons',
            'type' => '',
            'parent_id' => 3,
            'menu_id' => 1,
            'order' => 1,
        ]);


        DB::table('items')->insert([
            'name' => 'Docs',
            'link' => '/admin/docs',
            'type' => '',
            'parent_id' => 3,
            'menu_id' => 1,
            'order' => 2,
        ]);


        DB::table('items')->insert([
            'name' => 'Setting',
            'link' => '/admin/setting',
            'type' => '',
            'parent_id' => 3,
            'menu_id' => 1,
            'order' => 3,
        ]);



        DB::table('items')->insert([
            'name' => 'Menu',
            'link' => '/admin/menu',
            'type' => '',
            'parent_id' => 3,
            'menu_id' => 1,
            'order' => 4,
        ]);



        DB::table('items')->insert([
            'name' => 'LaraFlat',
            'link' => 'https://laraflat.com/',
            'type' => 'blank',
            'parent_id' => 0,
            'menu_id' => 2,
            'order' => 1,
        ]);
        DB::table('items')->insert([
            'name' => '5dmat-web',
            'link' => 'https://5dmat-web.com/',
            'type' => 'blank',
            'parent_id' => 0,
            'menu_id' => 2,
            'order' => 2
        ]);
        DB::table('items')->insert([
            'name' => 'StreamLab',
            'link' => 'https://streamlab.io/',
            'type' => 'blank',
            'parent_id' => 0,
            'menu_id' => 2,
            'order' => 3
        ]);




    }
}
