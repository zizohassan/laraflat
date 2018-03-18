<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Psy\Command\Command;
use Ramsey\Uuid\Generator\CombGenerator;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\MakeAdminModel::class,
        Commands\MakeModel::class,
        Commands\MakeAdminController::class,
        Commands\MakeController::class,
        Commands\MakeInterfaceEloquent::class,
        Commands\MakeApiController::class,
        Commands\MakeTransformer::class,
        Commands\MakeRequest::class,
        Commands\MakeAdminRequest::class,
        Commands\MakeMigration::class,
        Commands\ApiRequest::class,
        Commands\RollBack::class,
        Commands\MakeDataTable::class,
        Commands\MakeRelation::class,
        Commands\RelationRollBack::class,
        Commands\AddComment::class,
        Commands\AddRate::class,
    ];


    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('app/Application/routes/console.php');
    }
}
