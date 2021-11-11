<?php

namespace App\Services;

use Illuminate\Console\Concerns\InteractsWithIO;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class ConsoleService
{
    use InteractsWithIO;

    public static function print(string $message, ?bool $jump = false): void
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $outputStyle = new OutputFormatterStyle('red', '', ['bold']);
        $output->getFormatter()->setStyle('fire', $outputStyle);

        $space = $jump ? "\n" : '';
        $output->writeln($message.$space);
    }
}
