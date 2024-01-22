<?php

namespace App\Console;

use App\Console\Commands\Bookshelves\SetupCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Kiwilan\Steward\Commands\Scout\ScoutFreshCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(ScoutFreshCommand::class)
            ->at('01:00')
            ->mondays()
            ->onSuccess(function () {
                Log::info('ScoutFreshCommand executed successfully');
            })
            ->onFailure(function () {
                Log::error('ScoutFreshCommand failed');
            });

        $schedule->command(SetupCommand::class)
            ->at('02:00')
            ->daily()
            ->onSuccess(function () {
                Log::info('SetupCommand executed successfully');
            })
            ->onFailure(function () {
                Log::error('SetupCommand failed');
            });
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
