<?php

namespace App\Console\Commands\Bookshelves;

use File;
use Artisan;
use Illuminate\Console\Command;

class SampleBooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:sample-books';

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
        $this->alert('Bookshelves: sample books');

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
