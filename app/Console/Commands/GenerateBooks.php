<?php

namespace App\Console\Commands;

use Artisan;
use Storage;
use App\Utils\EpubParser;
use Illuminate\Console\Command;

class GenerateBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate books database from storage/books';

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
        $this->info('Generate books from storage/books...');
        Artisan::call('storage:link');

        $files = Storage::disk('public')->allFiles('books');
        foreach ($files as $key => $file) {
            if (array_key_exists('extension', pathinfo($file)) && 'epub' === pathinfo($file)['extension']) {
                EpubParser::getMetadata($file);
            }
        }

        $this->info('Done!');
    }
}
