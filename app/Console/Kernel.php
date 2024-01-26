<?php

namespace App\Console;

use App\Console\Commands\Bookshelves\SetupCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Kiwilan\Steward\Commands\Scout\ScoutFreshCommand;
use Kiwilan\Steward\Utils\Journal;

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
                Journal::info('ScoutFreshCommand executed successfully');
            })
            ->onFailure(function () {
                Journal::error('ScoutFreshCommand failed')->toDatabase();
            });

        $schedule->command(SetupCommand::class)
            ->at('02:00')
            ->daily()
            ->onSuccess(function () {
                Journal::info('SetupCommand executed successfully');
            })
            ->onFailure(function () {
                Journal::error('SetupCommand failed')->toDatabase();
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
