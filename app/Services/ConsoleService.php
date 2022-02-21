<?php

namespace App\Services;

use Illuminate\Console\Concerns\InteractsWithIO;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Throwable;

class ConsoleService
{
    use InteractsWithIO;

    public static function print(string $message, ?Throwable $th = null, bool $jump = false): void
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $outputStyle = new OutputFormatterStyle('red', '', ['bold']);
        $output->getFormatter()->setStyle('fire', $outputStyle);

        $space = $jump ? "\n" : '';

        if ($th) {
            $output->writeln("<fire>Error about {$message}</>{$space}");
            $output->writeln($th->getMessage());
        } else {
            $output->writeln("{$message}{$space}");
        }
    }
}
