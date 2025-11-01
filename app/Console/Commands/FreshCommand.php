<?php

namespace App\Console\Commands;

use App\Facades\Bookshelves;
use App\Models\Library;
use App\Utils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Kiwilan\Steward\Commands\Commandable;
use Kiwilan\Steward\Commands\Log\LogClearCommand;
use Kiwilan\Steward\Commands\Model\ModelBackupCommand;
use Kiwilan\Steward\Commands\Model\ModelRestoreCommand;

class FreshCommand extends Commandable
{
    protected $signature = 'fresh';

    protected $description = 'Erase all data and start fresh';

    public function handle(): int
    {
        $this->title();
        $this->infos();

        Artisan::call('optimize:fresh');
        Utils::clearCache();

        return Command::SUCCESS;
    }

    private function infos(): void
    {
        $this->newLine();
        $this->comment('Convert covers: '.(Bookshelves::convertCovers() ? 'enabled' : 'disabled'));
        $this->comment('Queue: '.config('queue.default'));
        if (config('queue.default') === 'redis') {
            $this->comment(' Horizon: '.Bookshelves::horizonMaxProcesses());
        }
        $this->newLine();
        $this->info('Clear database... (fresh mode)');
        $this->clearFresh();
        $this->newLine();
    }

    private function clearFresh(): void
    {
        $this->call('horizon:clear', ['--force' => true]);

        $is_exists = Schema::hasTable('users');
        if (! $is_exists) {
            $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);
        }

        $this->call(ModelBackupCommand::class, [
            'model' => 'App\Models\User',
        ]);

        $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);
        $this->comment('Database reset!');

        $this->call(ModelRestoreCommand::class, [
            'model' => 'App\Models\User',
        ]);

        $this->call(LogClearCommand::class);

        Library::cacheClear();

        $this->call('db:seed', [
            '--class' => 'EmptySeeder',
            '--force' => true,
        ]);

        $this->newLine();
    }
}
