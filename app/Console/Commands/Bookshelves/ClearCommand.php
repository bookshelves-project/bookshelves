<?php

namespace App\Console\Commands\Bookshelves;

use Artisan;
use Illuminate\Console\Command;

class ClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear temporary files from Bookshelves';

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
        $this->alert('Bookshelves: clear');
        $this->clearDir(storage_path('app/public/debug'));
        $this->clearDir(storage_path('app/public/cache'));
        $this->clearDir(storage_path('app/public/temp'));
        $this->clearDir(storage_path('app/public/glide'));

        Artisan::call('cache:clear', [], $this->getOutput());
        Artisan::call('route:clear', [], $this->getOutput());
        Artisan::call('config:clear', [], $this->getOutput());
        Artisan::call('view:clear', [], $this->getOutput());
        Artisan::call('optimize:clear', [], $this->getOutput());
        Artisan::call('webreader:clear', [], $this->getOutput());

        $this->newLine();

        return 0;
    }

    public function clearDir(string $dir)
    {
        $leave_files = ['.gitignore'];

        foreach (glob("$dir/*") as $file) {
            if (! in_array(basename($file), $leave_files)) {
                if (is_dir($file)) {
                    rmdir_recursive($file);
                } else {
                    unlink($file);
                }
            }
        }

        $path = 'storage/app/public/' . basename($dir);
        $this->info("Clear $path");
    }
}
