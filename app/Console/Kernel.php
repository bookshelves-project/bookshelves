<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Kiwilan\Steward\Commands\Publish\PublishScheduledCommand;
use Kiwilan\Steward\Services\NotifyService;
use Spatie\Health\Commands\DispatchQueueCheckJobsCommand;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\Health\Commands\ScheduleCheckHeartbeatCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(RunHealthChecksCommand::class)->everyMinute();
        $schedule->command(ScheduleCheckHeartbeatCommand::class)->everyMinute();
        $schedule->command(PublishScheduledCommand::class)->everyMinute();
        $schedule->command(DispatchQueueCheckJobsCommand::class)->everyMinute();

        if (config('app.backup')) {
            $schedule->command('backup:clean')->daily()->at('01:00');
            $schedule->command('backup:run')->daily()->at('01:30')
                ->onFailure(function () {
                    $name = config('app.name');
                    NotifyService::make()
                        ->message("[{$name}] The backup failed to run. Please check the logs.")
                        ->send()
                    ;
                })
                ->onSuccess(function () {
                    $name = config('app.name');
                    NotifyService::make()
                        ->message("[{$name}] The backup successfully ran.")
                        ->send()
                    ;
                })
            ;
        }
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
