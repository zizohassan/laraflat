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
            'name' => 'LaraFlat',
            'link' => 'https://laraflat.com/',
            'type' => 'blank',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 1,
        ]);
        DB::table('items')->insert([
            'name' => '5dmat-web',
            'link' => 'https://5dmat-web.com/',
            'type' => 'blank',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 2
        ]);
        DB::table('items')->insert([
            'name' => 'StreamLab',
            'link' => 'https://streamlab.io/',
            'type' => 'blank',
            'parent_id' => 0,
            'menu_id' => 1,
            'order' => 3
        ]);




    }
}
