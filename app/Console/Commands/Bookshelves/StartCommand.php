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
                            {--u|users : start with users and roles sample}
                            {--r|roles : generate roles sample}
                            {--f|fake : start with fake comments and favorites sample}';

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
        $fake = $this->option('fake') ?? null;

        Artisan::call('migrate:fresh --force', [], $this->getOutput());
        Storage::disk('public')->deleteDirectory('media');

        Artisan::call('bookshelves:generate', [
            '--fresh' => true,
            '--force' => true,
        ], $this->getOutput());

        Artisan::call('bookshelves:sample', [
            '--users' => $users,
            '--roles' => $roles,
            '--fake'  => $fake,
        ], $this->getOutput());

        return 0;
    }
}
