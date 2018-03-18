<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminGroup::class);
        $this->call(AdminUser::class);
        $this->call(Permissions::class);
        $this->call(AddSetting::class);
        $this->call(AddMenu::class);
        $this->call(AddPage::class);
        $this->call(AddItemsToMenu::class);
        $this->call(CommandPage::class);
        $this->call(Cat::class);
    }
}
