<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\ScoutFreshProcess;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Kiwilan\Steward\Commands\Commandable;

class StartupCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:startup
                            {--a|api : use external API for more data}
                            {--A|admin : generate admin, replace if exist}
                            {--f|fresh : erase database and fresh installation, generate books and relations, all assets and selection books}
                            {--s|sample : fake users with comments/favorites and CMS with posts and pages}
                            {--l|limit= : limit epub files to generate, useful for debug}
                            {--D|default : use default cover for all (skip covers step)}
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
        $this->title();

        $this->info('This command allow speed installation to group other bookshelves commands.');
        $this->newLine();

        $force = $this->option('force') ?: false;
        $fresh = $this->option('fresh') ?: false;
        $api = $this->option('api') ?: false;
        $admin = $this->option('admin') ?: false;
        $sample = $this->option('sample') ?: false;
        $limit = $this->option('limit') ? intval(str_replace('=', '', $this->option('limit'))) : false;
        $verbose = $this->option('verbose') ?: false;

        if ($fresh) {
            if (! $force) {
                $this->askOnProduction();
            }

            Artisan::call('migrate:fresh --force', [], $this->getOutput());
        }

        Artisan::call('optimize:clear', [], $this->getOutput());

        // Admin.
        Artisan::call('bookshelves:admin', [
            '--force' => $force,
        ], $this->getOutput());

        // Make.
        Artisan::call('bookshelves:make', [
            '--fresh' => $fresh,
            '--limit' => $limit,
            '--verbose' => $verbose,
            '--force' => $force,
        ], $this->getOutput());
        // API.
        if ($api) {
            Artisan::call('bookshelves:api', [
                '--books' => true,
                '--authors' => true,
                '--series' => true,
                '--fresh' => $fresh,
                '--force' => $force,
                '--verbose' => $verbose,
            ], $this->getOutput());
        }

        if (! $verbose) {
            Artisan::call('clear:all', [], $this->getOutput());
        }

        // Sample users.
        // if ($sample) {
        //     Artisan::call('bookshelves:sample', [
        //         '--users' => true,
        //         '--cms' => true,
        //         '--force' => $force,
        //     ], $this->getOutput());
        // }

        // Scout.
        ScoutFreshProcess::dispatch();

        // Stats.
        // Artisan::call('bookshelves:stats', [], $this->getOutput());
        // $this->newLine();

        Artisan::call('optimize:fresh', [], $this->getOutput());

        $this->info('Done!');

        return Command::SUCCESS;
    }
}
