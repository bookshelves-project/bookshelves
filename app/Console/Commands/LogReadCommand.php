<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LogReadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:read';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $message = 'message';

        // $process = new Process(['echo "" > storage/logs/epubparser.log']);
        // $process->setTimeout(0);
        // $process->start();
        // $iterator = $process->getIterator($process::ITER_SKIP_ERR | $process::ITER_KEEP_OUTPUT);
        // foreach ($iterator as $data) {
        //     echo $data;
        // }

        // Log::channel('epubparser')->emergency($message);
        // Log::channel('epubparser')->alert($message);
        // Log::channel('epubparser')->critical($message);
        // Log::channel('epubparser')->error($message);
        // Log::channel('epubparser')->warning($message);
        // Log::channel('epubparser')->notice($message);
        // Log::channel('epubparser')->info($message);
        // Log::channel('epubparser')->debug($message);

        // $logFile = file(storage_path("/logs/epubparser.log"));
        // // dump($logFile);
        // $logCollection = [];
        // // Loop through an array, show HTML source as HTML source; and line numbers too.
        // foreach ($logFile as $line_num => $line) {
        //     $log = explode(' ', $line);
        //     // dump($log);
        //     $date = str_replace('[', '', $log[0]);
        //     $time = str_replace(']', '', $log[1]);
        //     $type = str_replace(':', '', $log[2]);
        //     $type = str_replace('local.', '', $type);
        //     $message = $log[3];
        //     array_push($logCollection, [
        //         'date' => $date,
        //         'time' => $time,
        //         'type' => $type,
        //         'message' => $message
        //     ]);
        // }
        // $this->alert('alert');
        // $this->warn('warn');
        // $this->error('error');
        // $this->info('info');
        // dump($logCollection);

        return Command::SUCCESS;
    }
}
