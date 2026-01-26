<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

class TokenCommand extends Commandable
{
    protected $signature = 'token';

    protected $description = 'Refresh download tokens for users.';

    public function handle(): int
    {
        $this->title();

        foreach (User::query()->get() as $user) {
            $user->generateDownloadToken();
        }

        return Command::SUCCESS;
    }
}
