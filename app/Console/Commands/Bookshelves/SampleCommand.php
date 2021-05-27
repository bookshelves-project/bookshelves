<?php

namespace App\Console\Commands\Bookshelves;

use File;
use Artisan;
use Illuminate\Console\Command;

class SampleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:sample
                            {--b|books : generate ebooks sample}
                            {--u|users : generate users with roles sample}
                            {--r|roles : generate roles sample}
                            {--f|fake : generate fake comments and favorites sample}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Bookshelves with libre eBooks to have data';

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

        $books = $this->option('books') ?? null;
        $users = $this->option('users') ?? null;
        $roles = $this->option('roles') ?? null;
        $fake = $this->option('fake') ?? null;

        if ($books) {
            $demoPath = database_path('seeders/demo-ebooks');
            $booksRawPath = storage_path('app/public/raw/books');
            $booksRawPathExist = File::exists($booksRawPath);

            if ($booksRawPathExist) {
                $this->warn('storage/app/public/raw/books path exists!');
                if ($this->confirm('Do you want to erase raw/books directory to replace it with demo ebooks?', false)) {
                    $this->generate($booksRawPath, $demoPath);
                } else {
                    $this->warn('Operation cancelled by user');
                }
            } else {
                $this->generate($booksRawPath, $demoPath);
            }
            $this->newLine(2);
        }

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

        if ($fake) {
            $this->comment('Run comments and favorites seeders');
            Artisan::call('db:seed', ['--class' => 'CommentSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'FavoriteSeeder', '--force' => true]);
            $this->info('Seeders ready!');
        }
        

        return true;
    }

    public function generate(string $booksRawPath, string $demoPath)
    {
        File::deleteDirectory($booksRawPath);
        File::copyDirectory($demoPath, $booksRawPath);
        $this->info('Demo ebooks ready!');
        $command = 'books:generate -fF';
        Artisan::call($command, [], $this->getOutput());
    }
}
