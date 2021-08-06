<?php

namespace App\Console\Commands\Bookshelves;

use Artisan;
use Storage;
use Illuminate\Console\Command;

class StartCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:start
                            {--r|roles : generate roles}
                            {--u|users : generate users with roles}
                            {--a|account : generate fake comments, favorites sample (users with roles will be generated)}
                            {--s|selection : generate fake selection sample (users with roles will be generated)}
                            {--L|local : prevent external HTTP requests to public API for additional informations}
                            {--l|limit= : limit epub files to generate, useful for debug}
                            {--d|debug : generate metadata files into public/storage/debug for debug}
                            {--t|test : execute tests at the end}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to start with Bookshelves: migrate fresh and execute bookshelves:generate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = $this->option('users') ?? null;
        $roles = $this->option('roles') ?? null;
        $test = $this->option('test') ?? null;
        $local = $this->option('local') ?? null;
        $debug = $this->option('debug') ?? false;
        $limit = $this->option('limit');
        $limit = str_replace('=', '', $limit);
        $limit = intval($limit);
        $account = $this->option('account') ?? false;
        $selection = $this->option('selection') ?? false;

        Artisan::call('migrate:fresh --force', [], $this->getOutput());
        Storage::disk('public')->deleteDirectory('media');

        Artisan::call('bookshelves:generate', [
            '--fresh' => true,
            '--force' => true,
            '--local' => $local,
            '--debug' => $debug,
            '--limit' => $limit,
            '--test'  => $test,
        ], $this->getOutput());

        Artisan::call('bookshelves:sample', [
            '--users'     => $users,
            '--roles'     => $roles,
            '--account'   => $account,
            '--selection' => $selection,
        ], $this->getOutput());

        return 0;
    }
}
