<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Nova\Trix\PruneStaleAttachments;
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
        $schedule->command('cache:truncate')
            ->daily()
            ->appendOutputTo(storage_path('logs/cache-truncate.log'))
            ->runInBackground();

        $schedule->call(new PruneStaleAttachments)->daily();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
