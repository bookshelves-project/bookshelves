<?php

namespace App\Console;

use App\Console\Commands\MediaCleanCommand;
use App\Console\Commands\PublishScheduledCommand;
use App\Console\Commands\SubmissionRgpdVerificationCommand;
use App\Console\Commands\TagCleanCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
