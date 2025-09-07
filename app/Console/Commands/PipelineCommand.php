<?php

namespace App\Console\Commands;

use App\Jobs\PipelineJob;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

class PipelineCommand extends Commandable
{
    protected $signature = 'pipeline
                            {--f|fresh : Fresh install}
                            {--l|limit= : Limit the number of items to process}';

    protected $description = 'Execute all main commands to analyze media files.';

    public function __construct(
        public bool $fresh = false,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->title();

        $fresh = $this->optionBool('fresh');
        $limit = $this->optionInt('limit');

        if ($fresh) {
            $this->call(FreshCommand::class);
        }
        PipelineJob::dispatch($fresh, $limit);

        return Command::SUCCESS;
    }
}
