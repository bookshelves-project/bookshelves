<?php

namespace App\Console\Commands\Bookshelves;

use Artisan;
use Illuminate\Console\Command;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:setup
                            {--F|fresh : erase database and fresh installation, generate books and relations, all assets and selection books}
                            {--S|social : fake users with comments/favorites}
                            {--l|limit= : limit epub files to generate, useful for debug}
                            {--L|local : prevent external HTTP requests to public API for additional informations}
                            {--d|debug : generate metadata files into public/storage/debug for debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup command to execute multiple commands into one from options, no option will just parse new books.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $app = config('app.name');
        $this->newLine();
        $this->alert("{$app}: setup");

        $this->info('This command allow speed installation to group other bookshelves commands.');
        $this->newLine();

        $fresh = $this->option('fresh') ?? false;
        $social = $this->option('social') ?? false;
        $limit = $this->option('limit') ? intval(str_replace('=', '', $this->option('limit'))) : false;
        $local = $this->option('local') ?? false;
        $debug = $this->option('debug') ?? false;

        if ($fresh) {
            Artisan::call('migrate:fresh --force', [], $this->getOutput());
            $this->newLine();
        }

        /*
         * Generate commands
         */
        Artisan::call('bookshelves:generate', [
            '--local' => $local,
            '--fresh' => $fresh,
            '--limit' => $limit,
            '--debug' => $debug,
        ], $this->getOutput());
        Artisan::call('bookshelves:assets', [
            '--books' => true,
            '--authors' => true,
            '--series' => true,
            '--local' => $local,
            '--fresh' => $fresh,
        ], $this->getOutput());
        Artisan::call('bookshelves:cms', [], $this->getOutput());

        Artisan::call('bookshelves:stats', [], $this->getOutput());
        $this->newLine();

        if (! $debug) {
            Artisan::call('bookshelves:clear', [], $this->getOutput());
        }

        Artisan::call('bookshelves:sample', [
            '--admin' => true,
            '--selection' => $fresh,
            '--comments' => $social,
            '--force' => true,
        ], $this->getOutput());

        Artisan::call('bookshelves:scout', [], $this->getOutput());

        $this->info('Done!');
    }
}
