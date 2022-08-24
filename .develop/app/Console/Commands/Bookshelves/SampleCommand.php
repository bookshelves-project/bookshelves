<?php

namespace App\Console\Commands\Bookshelves;

use App\Console\CommandProd;
use App\Models\User;
use Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SampleCommand extends CommandProd
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:sample
                            {--a|admin : generate only admin}
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
     */
    public function handle(): bool
    {
        $this->intro();

        $admin = $this->option('admin') ?? false;
        $users = $this->option('users') ?? false;
        $cms = $this->option('cms') ?? false;
        $force = $this->option('force') ?? false;

        $this->checkProd();

        if ($admin) {
            Storage::deleteDirectory(storage_path('app/public/media/users'));
            $this->clear();

            if (! User::exists()) {
                Artisan::call('db:seed', ['--class' => 'UserAdminSeeder', '--force' => true]);
                $this->info('Admin was created from `.env` variables with email '.config('app.admin.email'));
            } else {
                $this->error('Admin not created, some users exists!');
            }
        }

        if ($users) {
            $this->comment('Run users seeders');
            Artisan::call('db:seed', ['--class' => 'EmptySeeder', '--force' => true]);
            $this->newLine();
            $this->info('Seeders ready!');
            $this->newLine();

            $this->comment('Run selection seeders');
            Artisan::call('db:seed', ['--class' => 'SelectionSeeder', '--force' => true]);
            $this->info('Seeders ready!');
            $this->newLine();

            $this->comment('Run reviews and favorites seeders');
            Artisan::call('db:seed', ['--class' => 'ReviewSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'FavoriteSeeder', '--force' => true]);
            $this->info('Seeders ready!');
        }

        if ($cms) {
            $this->newLine();
            $this->comment('Run CMS seeders');
            Artisan::call('db:seed', ['--class' => 'CmsSeeder', '--force' => true]);
            $this->info('Seeders ready!');
            $this->newLine();

            $this->comment('Run posts & pages seeders');
            Artisan::call('db:seed', ['--class' => 'PostSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'PageSeeder', '--force' => true]);
            $this->info('Seeders ready!');
        }

        return true;
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
