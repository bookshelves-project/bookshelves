<?php

namespace App\Services;

use Illuminate\Console\Concerns\InteractsWithIO;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Throwable;

class ConsoleService
{
    use InteractsWithIO;

    public static function print(string $message, ?Throwable $th = null): void
    {
        // $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        // $outputStyle = new OutputFormatterStyle('red', '', ['bold']);
        // $output->getFormatter()->setStyle('fire', $outputStyle);

        // $output->writeln("<fire>Error about {$method}:</>");
        // $output->writeln($throwable->getMessage());
        // $output->writeln($throwable->getFile());

        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $outputStyle = new OutputFormatterStyle('red', '', ['bold']);
        $output->getFormatter()->setStyle('fire', $outputStyle);

        $space = "\n";
        $output->writeln($message.$space);
        if ($th) {
            $output->writeln($th->getMessage());
        }
    }
}
