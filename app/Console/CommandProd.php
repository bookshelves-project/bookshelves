<?php

namespace App\Console;

use Illuminate\Console\Command;

class CommandProd extends Command
{
    public function intro(?string $description = null)
    {
        $app = config('app.name');
        $this->newLine();

        $signature_name = explode("\n", $this->signature);
        if (array_key_exists(0, $signature_name)) {
            $signature_name = $signature_name[0];
            if (str_contains($signature_name, ':')) {
                $signature_name = explode(':', $signature_name);
                $signature_name = array_map('ucfirst', $signature_name);
                $signature_name = implode(' ', $signature_name);
            } else {
                $signature_name = ucfirst($signature_name);
            }
        } else {
            $signature_name = $this->signature;
        }

        $this->alert("{$signature_name}");
        $this->warn($this->description);
        $this->newLine();
    }

    public function checkProd()
    {
        $force = $this->option('force') ?: false; // @phpstan-ignore-line

        if ('local' !== config('app.env') && ! $force) {
            if ($this->confirm('This command will erase some data, do you really want to continue?', true)) {
                $this->info('Confirmed.');
            } else {
                $this->error('Stop.');

                return false;
            }
        }
    }
}
