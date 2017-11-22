<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AddMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        DB::table('menu')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('menu')->insert([
            'name' => 'Admin',
        ]);
        DB::table('menu')->insert([
            'name' => 'Main',
        ]);
        DB::table('menu')->insert([
            'name' => 'Website',
        ]);
    }
}
