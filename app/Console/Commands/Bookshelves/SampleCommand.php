<?php

namespace App\Console\Commands\Bookshelves;

use Artisan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
                            {--c|comments : generate fake comments, favorites sample (users with roles will be generated)}
                            {--s|selection : generate fake selection sample (user admin with roles will be generated)}
                            {--A|admin : generate only admin with roles}
                            {--F|force : skip confirm in prod}';

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
        $app = config('app.name');
        $this->newLine();
        $this->alert("$app: sample");

        $users = $this->option('users') ?? false;
        $roles = $this->option('roles') ?? false;
        $comments = $this->option('comments') ?? false;
        $selection = $this->option('selection') ?? false;
        $admin = $this->option('admin') ?? false;
        $force = $this->option('force') ?? false;

        if (config('app.env') !== 'local' && ! $force) {
            if ($this->confirm('This command will erase all users/roles/comments/selection/admin, do you really want to erase these data?', true)) {
                $this->info('Confirmed.');
            } else {
                $this->error('Stop.');
                return false;
            }
        }
        
        $users ? $roles = true : '';
        if ($admin) {
            if (! Role::exists()) {
                $roles = true;
            }
        }

        if ($comments) {
            if (! User::exists()) {
                $roles = true;
                $users = true;
            }
        }

        if ($selection) {
            $roles = true;
            $admin = true;
        }

        if ($roles) {
            $this->comment('Run roles seeders');
            DB::statement('SET foreign_key_checks=0');
            Role::truncate();
            DB::statement('SET foreign_key_checks=1');
            Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--force' => true]);
            $this->info('Seeders ready!');
            $this->newLine();
        }
        
        if ($admin) {
            // $users = User::all();
            // $users->each(function ($query) {
            //     $query->clearMediaCollection('avatar');
            // });
            Storage::deleteDirectory(storage_path('app/public/media/users'));
            DB::statement('SET foreign_key_checks=0');
            User::truncate();
            DB::statement('SET foreign_key_checks=1');
            
            if (! User::exists()) {
                Artisan::call('db:seed', ['--class' => 'UserAdminSeeder', '--force' => true]);
                $this->info('Admin was created from `.env` variables with email ' . config('bookshelves.admin.email'));
            } else {
                $this->error('Admin not created, some users exists!');
            }
            $this->newLine();
        }

        if ($users) {
            $this->comment('Run users seeders');
            Artisan::call('db:seed', ['--class' => 'UserSeeder', '--force' => true]);
            $this->newLine();
            $this->info('Seeders ready!');
            $this->newLine();
        }

        if ($comments) {
            $this->comment('Run comments and favorites seeders');
            Artisan::call('db:seed', ['--class' => 'CommentSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'FavoriteSeeder', '--force' => true]);
            $this->info('Seeders ready!');
            $this->newLine();
        }

        if ($selection) {
            $this->comment('Run selection seeders');
            Artisan::call('db:seed', ['--class' => 'SelectionSeeder', '--force' => true]);
            $this->info('Seeders ready!');
            $this->newLine();
        }

        return true;
    }
}
