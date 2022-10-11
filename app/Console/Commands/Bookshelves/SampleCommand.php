<?php

namespace App\Console\Commands\Bookshelves;

use App\Models\User;
use Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Kiwilan\Steward\Console\CommandProd;

class SampleCommand extends CommandProd
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:sample
                            {--u|users : generate users with reviews and favorites}
                            {--c|cms : generate pages, posts and CMS content}
                            {--F|force : skip confirm in prod}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Bookshelves with users features: roles, reviews, favorites and selection.';

    /**
     * Create a new command instance.
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
        $this->intro();

        $users = $this->option('users') ?? false;
        $cms = $this->option('cms') ?? false;
        $force = $this->option('force') ?? false;

        $this->checkProd();

        if ($users) {
            $this->comment('Run users seeders');
            Artisan::call('db:seed', ['--class' => 'UserSeeder', '--force' => true]);
            $this->newLine();
            $this->info('Seeders ready!');
            $this->newLine();

            $this->comment('Run selection seeders');
            Artisan::call('db:seed', ['--class' => 'SelectionableSeeder', '--force' => true]);
            $this->info('Seeders ready!');
            $this->newLine();

            $this->comment('Run reviews and favorites seeders');
            Artisan::call('db:seed', ['--class' => 'ReviewSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'FavoritableSeeder', '--force' => true]);
            $this->info('Seeders ready!');
        }

        if ($cms) {
            $this->comment('Run CMS seeders');
            Artisan::call('db:seed', ['--class' => 'PageSeeder', '--force' => true]);
            $this->info('Seeders ready!');
            $this->newLine();

            // $this->comment('Run posts & pages seeders');
            // Artisan::call('db:seed', ['--class' => 'PostSeeder', '--force' => true]);
            // Artisan::call('db:seed', ['--class' => 'PageSeeder', '--force' => true]);
            // $this->info('Seeders ready!');
        }

        return Command::SUCCESS;
    }

    public function clear()
    {
        DB::statement('SET foreign_key_checks=0');
        $users = User::all();
        foreach ($users as $user) {
            $user->media()->delete();
        }
        DB::table('users')->truncate();
        DB::statement('SET foreign_key_checks=1');
    }
}
