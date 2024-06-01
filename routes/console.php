<?php

use App\Console\Commands\Bookshelves\CleanCommand;
use App\Console\Commands\Bookshelves\MakeCommand;
use Illuminate\Support\Facades\Schedule;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Commands\Scout\ScoutFreshCommand;

// Schedule::call(function () {
//     DB::table('recent_users')->delete();
// })->daily();
// Schedule::call(new DeleteRecentUsers)->daily();

Schedule::command(ScoutFreshCommand::class)
    ->at('01:00')
    ->mondays()
    ->onSuccess(function () {
        Journal::info('ScoutFreshCommand executed successfully');
    })
    ->onFailure(function () {
        Journal::error('ScoutFreshCommand failed')->toDatabase();
    });

Schedule::command(MakeCommand::class)
    ->at('02:00')
    ->daily()
    ->onSuccess(function () {
        Journal::info('MakeCommand executed successfully');
    })
    ->onFailure(function () {
        Journal::error('MakeCommand failed')->toDatabase();
    });

Schedule::command(CleanCommand::class)
    ->at('00:00')
    ->mondays()
    ->onSuccess(function () {
        Journal::info('CleanCommand executed successfully');
    })
    ->onFailure(function () {
        Journal::error('CleanCommand failed')->toDatabase();
    });
