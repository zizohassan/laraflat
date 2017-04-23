<?php

use Illuminate\Database\Seeder;

class AdminGroup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'name' => 'Admin',
            'slug'=> 'admin',
            'description'=> 'Access to User , permission , role , groups roles',
        ]);
        DB::table('groups')->insert([
            'name' => 'User',
            'slug'=> 'user',
            'description'=> 'User group ',
        ]);
    }
}
