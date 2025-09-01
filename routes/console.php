<?php

use App\Console\Commands\Bookshelves\AnalyzeCommand;
use Illuminate\Support\Facades\Schedule;
use Kiwilan\LaravelNotifier\Facades\Journal;

Schedule::command(AnalyzeCommand::class)
    ->at('02:00')
    ->daily()
    ->onSuccess(function () {
        Journal::info('AnalyzeCommand executed successfully');
    })
    ->onFailure(function () {
        Journal::error('AnalyzeCommand failed')->toDatabase();
    });
