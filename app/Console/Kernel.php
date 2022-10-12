<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Kiwilan\Steward\Commands\MediaCleanCommand;
use Kiwilan\Steward\Commands\PublishScheduledCommand;
use Kiwilan\Steward\Commands\SubmissionRgpdVerificationCommand;
use Kiwilan\Steward\Commands\TagCleanCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(PublishScheduledCommand::class)->everyFifteenMinutes();
        $schedule->command(MediaCleanCommand::class)->daily();
        $schedule->command(TagCleanCommand::class)->daily();
        $schedule->command(SubmissionRgpdVerificationCommand::class)->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
