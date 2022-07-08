<?php

namespace App\Services;

use Illuminate\Console\Concerns\InteractsWithIO;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\ConsoleOutput;
use Throwable;

class ConsoleService
{
    use InteractsWithIO;

    public static function print(string $message, string $color = 'green', Throwable $th = null): void
    {
        $output = new ConsoleOutput();
        $style = new OutputFormatterStyle($color, '', []);
        $output->getFormatter()
            ->setStyle('info', $style);

        if ($th) {
            $output->writeln("<info>Error about {$message}</info>\n");
            $output->writeln($th->getMessage());
        } else {
            $output->writeln("<info>{$message}</info>");
        }
    }

    public static function newLine()
    {
        $output = new ConsoleOutput();
        $style = new OutputFormatterStyle('red', '', ['bold']);
        $output->getFormatter()
            ->setStyle('info', $style);
        $output->writeln('');
    }
}
