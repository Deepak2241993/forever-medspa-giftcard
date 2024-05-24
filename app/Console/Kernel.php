<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
     
    protected function schedule(Schedule $schedule)
    {
        
        //  $schedule->command('/usr/local/bin/php /home/u929332160/public_html/artisan mail:cron')->everyMinute();
        
        // $schedule->command('mail:cron')->everyMinute();
      $schedule->command('mail:cron')
    ->everyFiveMinutes()
    ->when(function () {
        return now()->minute % 30 == 0; // Execute only at 0 and 30 minutes past the hour
    });
    
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
