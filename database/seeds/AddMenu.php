<?php

use Illuminate\Database\Seeder;

class AddMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu')->insert([
            'name' => 'Admin',
        ]);
        DB::table('menu')->insert([
            'name' => 'Main',
        ]);
    }
}
