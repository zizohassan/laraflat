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
        $keyType = "admin";
        $adminPermissions = [];
        foreach (getControllerByType($keyType, 'array') as $keryController => $controller) {
            foreach (getMethodByController($keryController, $keyType, 'array') as $methodKey => $method) {
                if ($method != "__construct") {
                    $array = [
                        'name' => "admin-admin-$method-$controller",
                        'slug' => ltrim($keryController, '-') . '-' . $method,
                        'description' => "Allow Admin $keyType on $method in controller $controller",
                        'controller_name' => $controller,
                        'method_name' => $method,
                        'controller_type' => $keyType,
                        'namespace' => ltrim(str_replace('-', '\\', $keryController), '\\'),
                        'permission' => 1
                    ];
                    $item = \App\Application\Model\Permission::create($array);
                    $adminPermissions[] = $item->id;
                    \App\Application\Model\Group::find(1)->permission()->attach($item->id);
                }
            }
        }
//        dump(count($adminPermissions));
        \App\Application\Model\Group::find(1)->permission()->sync($adminPermissions);

        $adminPermissions = [];
        foreach (getControllerByType('website', 'array') as $keryController => $controller) {
            foreach (getMethodByController($keryController, $keyType, 'array') as $methodKey => $method) {
                if ($method != "__construct") {
                    $array = [
                        'name' => "admin-website-$method-$controller",
                        'slug' => ltrim($keryController, '-') . '-' . $method,
                        'description' => "Allow Admin $keyType on $method in controller $controller",
                        'controller_name' => $controller,
                        'method_name' => $method,
                        'controller_type' => 'website',
                        'namespace' => ltrim(str_replace('-', '\\', $keryController), '\\'),
                        'permission' => 1
                    ];
                    $item = \App\Application\Model\Permission::create($array);
                    \App\Application\Model\Group::find(1)->permission()->attach($item->id);
                    $adminPermissions[] = $item->id;
                }
            }
        }
//        dump(count($adminPermissions));

        $adminPermissions = [];
        foreach (getControllerByType('website', 'array') as $keryController => $controller) {
            foreach (getMethodByController($keryController, $keyType, 'array') as $methodKey => $method) {
                if ($method != "__construct") {
                    $array = [
                        'name' => "user-website-$method-$controller",
                        'slug' => ltrim($keryController, '-') . '-' . $method,
                        'description' => "Allow User $keyType on $method in controller $controller",
                        'controller_name' => $controller,
                        'method_name' => $method,
                        'controller_type' => 'website',
                        'namespace' => ltrim(str_replace('-', '\\', $keryController), '\\'),
                        'permission' => 1
                    ];
                    $item = \App\Application\Model\Permission::create($array);
                    \App\Application\Model\Group::find(2)->permission()->attach($item->id);
                    $adminPermissions[] = $item->id;
                }
            }
        }
//        dump(count($adminPermissions));
//        dump(\App\Application\Model\Permission::count());
    }

}
