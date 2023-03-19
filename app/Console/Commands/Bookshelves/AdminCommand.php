<?php

namespace App\Console\Commands\Bookshelves;

use App\Models\User;
use Artisan;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\CommandSteward;

class AdminCommand extends CommandSteward
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:admin
                            {--F|force : skip confirm if admin exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->title();

        $allowed = false;

        $exist = User::where('email', config('app.admin.email'))->first();

        if ($exist) {
            if ($this->confirm('Admin exists, do you want to replace it?', false)) {
                $allowed = true;
            }
        } else {
            $allowed = true;
        }

        if ($allowed) {
            if ($exist) {
                $exist->delete();
            }
            Artisan::call('db:seed', ['--class' => 'EmptySeeder', '--force' => true]);
            $this->info('Admin was created from `.env` variables with email '.config('app.admin.email'));
        }

        return Command::SUCCESS;
    }
}
