<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('backup-server:dispatch-backups')->everyMinute();
        $schedule->command('backup-server:monitor')->daily();
        $schedule->command('backup-server:cleanup')->dailyAt('3:00');

        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        $schedule->command('laravel-version')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
