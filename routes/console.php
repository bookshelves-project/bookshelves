<?php

use App\Console\Commands\PipelineCommand;
use App\Console\Commands\TokenCommand;
use Illuminate\Support\Facades\Schedule;
use Kiwilan\LaravelNotifier\Facades\Journal;

Schedule::command(PipelineCommand::class)
    ->at('00:00')
    ->daily()
    ->onSuccess(function () {
        Journal::info('PipelineCommand executed successfully');
    })
    ->onFailure(function () {
        Journal::error('PipelineCommand failed')->toDatabase();
    });

Schedule::command(\Spatie\Health\Commands\DispatchQueueCheckJobsCommand::class)->everyMinute();
Schedule::command(\Spatie\Health\Commands\ScheduleCheckHeartbeatCommand::class)->everyMinute();
Schedule::command(TokenCommand::class)->daily()
    ->daily()
    ->at('05:00');
