<?php

namespace App\Console\Commands\Bookshelves;

use Artisan;
use App\Models\User;
use Illuminate\Console\Command;

class SampleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:sample
                            {--r|roles : generate roles}
                            {--u|users : generate users with roles}
                            {--a|account : generate fake comments, favorites sample (users with roles will be generated)}
                            {--s|selection : generate fake selection sample (user admin with roles will be generated)}
                            {--A|admin : generate only admin with roles}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Bookshelves with users features: roles, comments, favorites and selection.';

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
     */
    public function handle(): bool
    {
        $this->alert('Bookshelves: sample');

        $users = $this->option('users') ?? null;
        $roles = $this->option('roles') ?? null;
        $account = $this->option('account') ?? null;
        $selection = $this->option('selection') ?? null;
        $admin = $this->option('admin') ?? null;

        if ($users) {
            $this->comment('Run roles with users seeders');
            Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'UserSeeder', '--force' => true]);
            $this->info('Seeders ready!');
        }

        if ($roles) {
            $this->comment('Run roles seeders');
            Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--force' => true]);
            $this->info('Seeders ready!');
        }

        if ($account) {
            $this->comment('Run roles with users seeders');
            Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'UserSeeder', '--force' => true]);
            $this->info('Seeders ready!');

            $this->comment('Run comments and favorites seeders');
            Artisan::call('db:seed', ['--class' => 'CommentSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'FavoriteSeeder', '--force' => true]);
            $this->info('Seeders ready!');
        }

        if ($selection) {
            $this->comment('Run roles with users seeders');
            Artisan::call('db:seed', ['--class' => 'UserAdminSeeder', '--force' => true]);
            $this->info('Seeders ready!');

            $this->comment('Run selection seeders');
            Artisan::call('db:seed', ['--class' => 'SelectionSeeder', '--force' => true]);
            $this->info('Seeders ready!');
        }

        if ($admin) {
            if (! User::exists()) {
                Artisan::call('db:seed', ['--class' => 'UserAdminSeeder', '--force' => true]);
            } else {
                $this->info('Admin not created, some users exists!');
            }
        }

        return true;
    }
}
