<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AddSetting extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        DB::table('setting')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('setting')->insert([
            'name' => 'siteTitle',
            'type'=> 'text',
            'body_setting' => 'LaraFlat'
        ]);

        DB::table('setting')->insert([
            'name' => 'GOOGLE_API_MAP',
            'type'=> 'text',
            'body_setting' => ''
        ]);


    }
}
