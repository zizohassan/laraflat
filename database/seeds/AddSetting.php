<?php

use Illuminate\Database\Seeder;

class AddSetting extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'name' => 'siteTitle',
            'type'=> 'text',
            'body_setting' => 'LaraFlat'
        ]);

    }
}
