<?php

use Illuminate\Database\Seeder;

class CommandPage extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            'name' => 'Page',
            'options' => 'title:string:min-1_max-70_required:true,body:text:min-1_required:true,active:boolean:required_integer:false',
            'command' => 'laraflat:admin_model',
        ];
        \App\Application\Model\Command::create($array);
        $array = [
            'name' => 'PageComment',
            'options' => 'page',
            'command' => 'laraflat:comment',
        ];
        \App\Application\Model\Command::create($array);
        $array = [
            'name' => 'Categorie',
            'options' => 'title:string:min-1_max-80_required:false',
            'command' => 'laraflat:admin_model',
        ];
        \App\Application\Model\Command::create($array);
    }
}
