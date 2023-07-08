<?php

namespace App\Console;

use App\Jobs\DeletePostJop;
use App\Jobs\HttpRequestJop;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {

         //$schedule->command('delete-posts')->minute();
         $schedule->job(new DeletePostJop)->daily();
         $schedule->job(new HttpRequestJop)->everySixHours();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');

    }
}
