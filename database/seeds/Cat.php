<?php

use Illuminate\Database\Seeder;

class Cat extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array  =[
            'title' => '{"en":"Genaral","ar":"العام"}'
        ];
        \App\Application\Model\Categorie::create($array);
        $array  =[
            'title' => '{"en":"cars","ar":"السيارات"}'
        ];
        \App\Application\Model\Categorie::create($array);
    }
}
