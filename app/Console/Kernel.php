<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
