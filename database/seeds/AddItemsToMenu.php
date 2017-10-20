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
            'name' => encodeJson(['ar' => ' الرئيسية ', 'en' => 'Home']),
            'link' => '/admin/home',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 1,
            'icon' => '<i class="material-icons">home</i>'
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => 'الاقسام', 'en' => 'Categories']),
            'link' => '/admin/categorie',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 2,
            'icon' => '<i class="material-icons">control_point_duplicate</i>'
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => '  المستخدمين ', 'en' => 'User']),
            'link' => '/admin/users',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 3,
            'icon' => '<i class="material-icons">account_circle</i>'
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' اعدادت الموقع ', 'en' => 'Setting']),
            'link' => '/admin/settings',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 4,
            'icon' => '<i class="material-icons">insert_emoticon</i>'
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' الصفحات ', 'en' => 'Page']),
            'link' => '/admin/page',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 5,
            'icon' => '<i class="material-icons">find_in_page</i>'
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' سجل البينات ', 'en' => 'Logs']),
            'link' => '/admin/log',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 6,
            'icon' => '<i class="material-icons">info</i>'
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' الاحصائيات ', 'en' => 'Statistics']),
            'link' => '/admin/links',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 7,
            'icon' => '<i class="material-icons">insert_chart</i>'
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' اتصل بنا ', 'en' => 'Contact Us']),
            'link' => '/admin/contact',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 8,
            'icon' => '<i class="material-icons">perm_contact_calendar</i>'
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' المستخدمين ', 'en' => "Users"]),
            'link' => '/admin/user',
            'type' => '',
            'parent_id' => 3,
            'menu_id' => 1,
            'order' => 1
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' جروبات الاعضاء ', 'en' => 'Groups']),
            'link' => '/admin/group',
            'type' => '',
            'parent_id' => 3,
            'menu_id' => 1,
            'order' => 2,
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' قوانين الاستخدام ', 'en' => 'Roles']),
            'link' => '/admin/role',
            'type' => '',
            'parent_id' => 3,
            'menu_id' => 1,
            'order' => 3,
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' التصاريح ', 'en' => 'Permissions']),
            'link' => '/admin/permission',
            'type' => '',
            'parent_id' => 3,
            'menu_id' => 1,
            'order' => 4,
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' ايقونات الموقع ', 'en' => 'Icons']),
            'link' => '/admin/icons',
            'type' => '',
            'parent_id' => 4,
            'menu_id' => 1,
            'order' => 1,
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => '  التوثيق ', 'en' => 'Docs']),
            'link' => '/admin/docs',
            'type' => '',
            'parent_id' => 4,
            'menu_id' => 1,
            'order' => 2,
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' اعدادت الموقع ', 'en' => 'Settings']),
            'link' => '/admin/setting',
            'type' => '',
            'parent_id' => 4,
            'menu_id' => 1,
            'order' => 3,
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' القوائم ', 'en' => 'Menu']),
            'link' => '/admin/menu',
            'type' => '',
            'parent_id' => 4,
            'menu_id' => 1,
            'order' => 4,
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' لارافلات ', 'en' => "laraFalt"]),
            'link' => 'https://laraflat.com/',
            'type' => 'blank',
            'parent_id' => 0,
            'menu_id' => 2,
            'order' => 1,
        ]);
        DB::table('items')->insert([

            'name' => encodeJson(['ar' => ' خدمات ويب ', 'en' => '5dmat-web']),
            'link' => 'https://5dmat-web.com/',
            'type' => 'blank',
            'parent_id' => 0,
            'menu_id' => 2,
            'order' => 2
        ]);
        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' ستريم لاب ', 'en' => 'StreamLab']),
            'link' => 'https://streamlab.io/',
            'type' => 'blank',
            'parent_id' => 0,
            'menu_id' => 2,
            'order' => 3
        ]);


    }
}
