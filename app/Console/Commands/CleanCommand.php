<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

class CleanCommand extends Commandable
{
    protected $signature = 'clean';

    protected $description = 'Clean indexes and cache.';

    public function __construct(
        public bool $fresh = false,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->title();

        \App\Jobs\Clean\CleanIndexesJob::dispatch();
        \App\Jobs\Clean\CleanNotifyJob::dispatch();
        \App\Jobs\Clean\CleanJob::dispatch();

        return Command::SUCCESS;
    }
}
