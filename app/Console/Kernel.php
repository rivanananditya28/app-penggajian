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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //BACKUP DATABASE
        $schedule->command('cron:backup-db')->monthlyOn(1, '01:00'); 
        //GENERATE GAJI POKOK FREELANCE    
        $schedule->command('cron:gaji-pokok')->monthlyOn(1, '01:15');
        //IMPORT GAJI POKOK FREELANCE KE LABA RUGI
        $schedule->command('cron:import-gaji')->monthlyOn(1, '01:16');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
