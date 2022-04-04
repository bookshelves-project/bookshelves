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
                            {--f|fresh : erase database and fresh installation, generate books and relations, all assets and selection books}
                            {--s|sample : fake users with comments/favorites and CMS with posts and pages}
                            {--l|limit= : limit epub files to generate, useful for debug}
                            {--L|local : prevent external HTTP requests to public API for additional informations}
                            {--d|debug : generate metadata files into public/storage/debug for debug}
                            {--F|force : skip confirm in prod}';

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

        $force = $this->option('force') ?? false;
        $fresh = $this->option('fresh') ?? false;
        $sample = $this->option('sample') ?? false;
        $limit = $this->option('limit') ? intval(str_replace('=', '', $this->option('limit'))) : false;
        $local = $this->option('local') ?? false;
        $debug = $this->option('debug') ?? false;

        if ('local' !== config('app.env') && ! $force) {
            if ($this->confirm('This command will erase all users/comments/selection/admin, do you really want to erase these data?', true)) {
                $this->info('Confirmed.');
            } else {
                $this->error('Stop.');

                return false;
            }
        }

        if ($fresh) {
            Artisan::call('migrate:fresh --force', [], $this->getOutput());
            $this->newLine();
        }

        /**
         * Admin.
         */
        Artisan::call('bookshelves:sample', [
            '--admin' => true,
            '--cms' => $sample,
            '--force' => true,
        ], $this->getOutput());

        /**
         * Generate.
         */
        Artisan::call('bookshelves:generate', [
            '--fresh' => $fresh,
            '--limit' => $limit,
            '--debug' => $debug,
        ], $this->getOutput());
        /**
         * Assets.
         */
        Artisan::call('bookshelves:assets', [
            '--books' => true,
            '--authors' => true,
            '--series' => true,
            '--local' => $local,
            '--fresh' => $fresh,
        ], $this->getOutput());

        if (! $debug) {
            Artisan::call('bookshelves:clear', [], $this->getOutput());
        }

        /**
         * Sample users.
         */
        Artisan::call('bookshelves:sample', [
            '--users' => $sample,
            '--cms' => $sample,
            '--force' => true,
        ], $this->getOutput());

        /**
         * Scout.
         */
        Artisan::call('bookshelves:scout', [], $this->getOutput());
        $this->newLine();

        /**
         * Stats.
         */
        Artisan::call('bookshelves:stats', [], $this->getOutput());
        $this->newLine();

        $this->info('Done!');
    }
}
