<?php

namespace App\Console\Commands\Bookshelves;

use App\Models\User;
use Artisan;
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
                            {--u|users : generate users}
                            {--c|comments : generate fake comments, favorites sample (users will be generated)}
                            {--s|selection : generate fake selection sample (user admin will be generated)}
                            {--a|admin : generate only admin}
                            {--p|posts : generate posts}
                            {--F|force : skip confirm in prod}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Bookshelves with users features: roles, comments, favorites and selection.';

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
        $app = config('app.name');
        $this->newLine();
        $this->alert("{$app}: sample");

        $users = $this->option('users') ?? false;
        $comments = $this->option('comments') ?? false;
        $selection = $this->option('selection') ?? false;
        $admin = $this->option('admin') ?? false;
        $force = $this->option('force') ?? false;
        $posts = $this->option('posts') ?? false;

        if ('local' !== config('app.env') && ! $force) {
            if ($this->confirm('This command will erase all users/comments/selection/admin, do you really want to erase these data?', true)) {
                $this->info('Confirmed.');
            } else {
                $this->error('Stop.');

                return false;
            }
        }

        // $users ? $roles = true : '';
        // if ($admin) {
        //     if (! Role::exists()) {
        //         $roles = true;
        //     }
        // }

        if ($comments) {
            if (! User::exists()) {
                $roles = true;
                $users = true;
            }
        }

        if ($selection) {
            // $roles = true;
            $admin = true;
        }

        // if ($roles) {
        //     $this->comment('Run roles seeders');
        //     $this->setRoles();
        //     $this->info('Seeders ready!');
        //     $this->newLine();
        // }

        if ($admin) {
            Storage::deleteDirectory(storage_path('app/public/media/users'));
            $this->clear();

            if (! User::exists()) {
                Artisan::call('db:seed', ['--class' => 'UserAdminSeeder', '--force' => true]);
                $this->info('Admin was created from `.env` variables with email '.config('bookshelves.admin.email'));
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

        if ($posts) {
            $this->comment('Run posts & pages seeders');
            Artisan::call('db:seed', ['--class' => 'PostSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'PageSeeder', '--force' => true]);
            $this->info('Seeders ready!');
            $this->newLine();
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
        // DB::table('roles')->truncate();
        // DB::table('permissions')->truncate();
        // DB::table('model_has_roles')->truncate();
        // DB::table('model_has_permissions')->truncate();
        DB::statement('SET foreign_key_checks=1');
        // Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--force' => true]);
    }
}
