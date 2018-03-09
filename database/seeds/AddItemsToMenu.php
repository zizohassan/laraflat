<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AddItemsToMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        DB::table('items')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' الرئيسية ', 'en' => 'Home']),
            'link' => '/admin/home',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 1,
            'icon' => '<i class="material-icons">home</i>',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\HomeController"])
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => 'الاقسام', 'en' => 'Categories']),
            'link' => '/admin/categorie',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 2,
            'icon' => '<i class="material-icons">control_point_duplicate</i>',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\CategorieController"])
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => '  المستخدمين ', 'en' => 'User']),
            'link' => '#',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 3,
            'icon' => '<i class="material-icons">account_circle</i>',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\UserController", "App\\Application\\Controllers\\Admin\\GroupController", "App\\Application\\Controllers\\Admin\\RoleController", "App\\Application\\Controllers\\Admin\\Development\\PermissionController"])
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' اعدادت الموقع ', 'en' => 'Setting']),
            'link' => '#',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 4,
            'icon' => '<i class="material-icons">insert_emoticon</i>',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\SettingController", "App\\Application\\Controllers\\Admin\\HomeController", "App\\Application\\Controllers\\Admin\\MenuController"])
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' الصفحات ', 'en' => 'Page']),
            'link' => '/admin/page',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 5,
            'icon' => '<i class="material-icons">find_in_page</i>',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\PageController"])
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' ادارة الملفات ', 'en' => 'File Manager']),
            'link' => '/admin/file-manager',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 6,
            'icon' => '<i class="material-icons">folder</i>',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\HomeController"])
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' سجل البينات ', 'en' => 'Logs']),
            'link' => '/admin/log',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 7,
            'icon' => '<i class="material-icons">info</i>',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\LogController"])
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' الاحصائيات ', 'en' => 'Statistics']),
            'link' => '/admin/links',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 8,
            'icon' => '<i class="material-icons">insert_chart</i>',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\UserController"])
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' اتصل بنا ', 'en' => 'Contact Us']),
            'link' => '/admin/contact',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 9,
            'icon' => '<i class="material-icons">perm_contact_calendar</i>',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\ContactController"])
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' المستخدمين ', 'en' => "Users"]),
            'link' => '/admin/user',
            'type' => '',
            'parent_id' => 3,
            'menu_id' => 1,
            'order' => 1,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\UserController"])
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' جروبات الاعضاء ', 'en' => 'Groups']),
            'link' => '/admin/group',
            'type' => '',
            'parent_id' => 3,
            'menu_id' => 1,
            'order' => 2,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\GroupController"])
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' قوانين الاستخدام ', 'en' => 'Roles']),
            'link' => '/admin/role',
            'type' => '',
            'parent_id' => 3,
            'menu_id' => 1,
            'order' => 3,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\RoleController"])
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' التصاريح ', 'en' => 'Permissions']),
            'link' => '/admin/permission',
            'type' => '',
            'parent_id' => 3,
            'menu_id' => 1,
            'order' => 4,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\Development\\PermissionController"])
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' ايقونات الموقع ', 'en' => 'Icons']),
            'link' => '/admin/icons',
            'type' => '',
            'parent_id' => 4,
            'menu_id' => 1,
            'order' => 1,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\HomeController"])
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => '  التوثيق ', 'en' => 'Docs']),
            'link' => '/admin/docs',
            'type' => '',
            'parent_id' => 4,
            'menu_id' => 1,
            'order' => 2,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\HomeController"])
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' اعدادت الموقع ', 'en' => 'Settings']),
            'link' => '/admin/setting',
            'type' => '',
            'parent_id' => 4,
            'menu_id' => 1,
            'order' => 3,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\SettingController"])
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' القوائم ', 'en' => 'Menu']),
            'link' => '/admin/menu',
            'type' => '',
            'parent_id' => 4,
            'menu_id' => 1,
            'order' => 4,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\MenuController"])
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' لارافلات ', 'en' => "laraFalt"]),
            'link' => 'https://laraflat.com/',
            'type' => 'blank',
            'parent_id' => 0,
            'menu_id' => 2,
            'order' => 1,
            'controller_path' => ''
        ]);
        DB::table('items')->insert([

            'name' => encodeJson(['ar' => ' خدمات ويب ', 'en' => '5dmat-web']),
            'link' => 'https://5dmat-web.com/',
            'type' => 'blank',
            'parent_id' => 0,
            'menu_id' => 2,
            'order' => 2,
            'controller_path' => ''
        ]);
        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' ستريم لاب ', 'en' => 'StreamLab']),
            'link' => 'https://streamlab.io/',
            'type' => 'blank',
            'parent_id' => 0,
            'menu_id' => 2,
            'order' => 3,
            'controller_path' => ''
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' تطوير  ', 'en' => 'Develop']),
            'link' => '#',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 9,
            'icon' => '<i class="material-icons">settings</i>',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\RelationController", "App\\Application\\Controllers\\Admin\\TranslationController", "App\\Application\\Controllers\\Admin\\CommandsController", "App\\Application\\Controllers\\Admin\\Development\\CustomPermissionsController"])
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' الاوامر ', 'en' => 'Commands']),
            'link' => '/admin/commands',
            'type' => '',
            'parent_id' => 21,
            'menu_id' => 1,
            'order' => 2,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\CommandsController"])
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => '  العلاقات ', 'en' => 'Relation']),
            'link' => '/admin/relation',
            'type' => '',
            'parent_id' => 21,
            'menu_id' => 1,
            'order' => 3,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\RelationController"])
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' الترجمة  ', 'en' => ' Translation ']),
            'link' => '/admin/translation',
            'type' => '',
            'parent_id' => 21,
            'menu_id' => 1,
            'order' => 3,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\TranslationController"])
        ]);
        DB::table('items')->insert([
            'name' => encodeJson(['ar' => '  تخصيص التصريحات  ', 'en' => ' Custom Permissions ']),
            'link' => '/admin/custom-permissions',
            'type' => '',
            'parent_id' => 21,
            'menu_id' => 1,
            'order' => 3,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\Development\\CustomPermissionsController"])
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' اوامر لارافيل  ', 'en' => ' Laravel Commands  ']),
            'link' => 'admin/laravel/commands',
            'type' => '',
            'parent_id' => 21,
            'menu_id' => 1,
            'order' => 3,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\CommandsController"])
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => '  التحكم في قواعد البينات  ', 'en' => ' DataBase Manager  ']),
            'link' => '/adminer.php',
            'type' => 'blank',
            'parent_id' => 21,
            'menu_id' => 1,
            'order' => 3,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\CommandsController"])
        ]);


        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' المظهر  ', 'en' => 'Theme']),
            'link' => '#',
            'type' => '',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 10,
            'icon' => '<i class="material-icons">color_lens</i>',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\Themes\\ThemeController"])
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' لوحة تحكم المدير  ', 'en' => 'Admin']),
            'link' => 'admin/theme/admin',
            'type' => '',
            'parent_id' => 28,
            'menu_id' => 1,
            'order' => 10,
            'icon' => '',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\Themes\\ThemeController"])
        ]);
        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' الموقع ', 'en' => 'Website']),
            'link' => 'admin/theme/website',
            'type' => '',
            'parent_id' => 28,
            'menu_id' => 1,
            'order' => 10,
            'icon' => '',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\Themes\\ThemeController"])
        ]);
        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' رئيسية الموقع ', 'en' => 'Home Widget']),
            'link' => 'admin/theme/homepage',
            'type' => '',
            'parent_id' => 28,
            'menu_id' => 1,
            'order' => 10,
            'icon' => '',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\Themes\\ThemeController"])
        ]);
        DB::table('items')->insert([
            'name' => encodeJson(['ar' => ' السيد بار ', 'en' => 'Sidebar Widget']),
            'link' => 'admin/theme/sidebar',
            'type' => '',
            'parent_id' => 28,
            'menu_id' => 1,
            'order' => 10,
            'icon' => '',
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\Themes\\ThemeController"])
        ]);

        DB::table('items')->insert([
            'name' => encodeJson(['ar' => '  رفع / استخراج المديولات ', 'en' => ' Export \ Import Models  ']),
            'link' => 'admin/exportImport',
            'type' => 'blank',
            'parent_id' => 21,
            'menu_id' => 1,
            'order' => 5,
            'controller_path' => json_encode(["App\\Application\\Controllers\\Admin\\CommandsController"])
        ]);

    }
}
