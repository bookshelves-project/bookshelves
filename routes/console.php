<?php

use App\Console\Commands\PipelineCommand;
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
