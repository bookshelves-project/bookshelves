<?php

namespace App\Console\Commands;

use File;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Question\Question;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';
    protected $appName = 'Bookshelves';
    protected $appNameSlug = '';
    protected $urlLocal = 'http://localhost:8000';
    protected $urlProd = 'https://bookshelves.ink';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installation setup with one command.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->appNameSlug = Str::slug($this->appName, '_');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->welcome();

        $this->newLine();
        $prod = false;

        $this->info('Config .env...');
        $requestCreateEnv = $this->createEnvFile();
        if ($requestCreateEnv) {
            $credentials = $this->requestDatabaseCredentials();
            $this->updateEnvironmentFile($credentials);
            Artisan::call('key:generate', [], $this->getOutput());
            $this->cleaningDev();
        }

        if ($this->confirm('Do you want setup this app in production?', false)) {
            $prod = true;

            $this->warn('~ Production enabled.'."\n");
            $production = $this->allowProduction();
            $this->updateEnvironmentFile($production);
        } else {
            $local = $this->setupLocal();
            $this->updateEnvironmentFile($local);
            $this->warn('~ Development enabled.'."\n");
        }
        $this->call('storage:link');

        $this->info('Node.js dependencies installation...');
        $process = new Process(['yarn','--colors=always']);
        $process->setTimeout(0);
        $process->start();
        $iterator = $process->getIterator($process::ITER_SKIP_ERR | $process::ITER_KEEP_OUTPUT);
        foreach ($iterator as $data) {
            echo $data;
        }
        $this->info('Laravel mix, wait a minute...');
        exec('yarn prod');

        $this->info('Cleaning...');
        if ($prod) {
            $this->cleaningProd();
        } else {
            $this->cleaningDev();
        }
        Artisan::call('config:cache');

        Artisan::call('setup:database', [], $this->getOutput());

        Artisan::call('scribe:generate');

        $this->newLine();
        $this->info('Application is ready!');

        $this->goodbye();
    }

    /**
     * Update the .env file from an array of $key => $value pairs.
     *
     * @return void
     */
    protected function updateEnvironmentFile(array $updatedValues)
    {
        $envFile = base_path('.env');

        foreach ($updatedValues as $key => $value) {
            if (strpos($value, ' ')) {
                file_put_contents($envFile, preg_replace(
                    "/{$key}=(.*)/",
                    "{$key}='{$value}'",
                    file_get_contents($envFile)
                ));
            } else {
                file_put_contents($envFile, preg_replace(
                    "/{$key}=(.*)/",
                    "{$key}={$value}",
                    file_get_contents($envFile)
                ));
            }
        }
    }

    protected function cleaningDev()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
    }

    protected function cleaningProd()
    {
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
    }

    /**
     * Display the welcome message.
     */
    protected function welcome()
    {
        $this->info('>> Welcome to '.$this->appName.' autosetup <<');
    }

    /**
     * Display the completion message.
     */
    protected function goodbye()
    {
        $this->info('>> The installation process is complete. <<');
    }

    /**
     * Allow production.
     *
     * @return array
     */
    protected function allowProduction()
    {
        return [
            'APP_ENV'                  => $this->ask('Environnement', 'production'),
            'APP_DEBUG'                => $this->ask('Debug', 'false'),
            'APP_URL'                  => $this->ask('Application URL', $this->urlProd),
            'SANCTUM_STATEFUL_DOMAINS' => $this->ask('Sanctum stateful domains', 'bookshelves.ink'),
            'SESSION_DOMAIN'           => $this->ask('Session domain', '.bookshelves.ink'),
        ];
    }

    protected function setupLocal()
    {
        return [
            'APP_URL'                    => $this->ask('Application URL', $this->urlLocal),
        ];
    }

    /**
     * Request the local database details from the user.
     *
     * @return array
     */
    protected function requestDatabaseCredentials()
    {
        return [
            'APP_NAME'          => $this->ask('App name', $this->appName),
            'DB_DATABASE'       => $this->ask('Database name', "$this->appNameSlug"),
            'DB_PORT'           => $this->ask('Database port', '3306'),
            'DB_USERNAME'       => $this->ask('Database user', 'root'),
            'DB_PASSWORD'       => $this->askHiddenWithDefault('Database password (leave blank for no password)'),
            'MAIL_HOST'         => $this->ask('Mail host', 'smtp.mailtrap.io'),
            'MAIL_USERNAME'     => $this->ask('Mail user', ''),
            'MAIL_PASSWORD'     => $this->ask('Mail password', ''),
            'TELESCOPE_ENABLED' => $this->ask('Telescope enabled?', 'false'),
        ];
    }

    /**
     * Create the initial .env file.
     */
    protected function createEnvFile()
    {
        if (! file_exists('.env')) {
            copy('.env.example', '.env');

            $this->warn('.env file successfully created'."\n");

            return true;
        }
        if ($this->confirm('.env detected, do you want to erase current .env file?', false)) {
            unlink('.env');
            copy('.env.example', '.env');

            $this->warn('~ .env file successfully recreated'."\n");

            return true;
        }
        $this->warn('~ .env file creation skipped'."\n");

        return false;
    }

    /**
     * Migrate the db with the new credentials.
     *
     * @param array $credentials
     *
     * @return void
     */
    protected function migrateDatabaseWithFreshCredentials($credentials)
    {
        foreach ($credentials as $key => $value) {
            $configKey = strtolower(str_replace('DB_', '', $key));

            if ('password' === $configKey && 'null' == $value) {
                config(["database.connections.mysql.{$configKey}" => '']);

                continue;
            }

            config(["database.connections.mysql.{$configKey}" => $value]);
        }

        $this->call('migrate');
    }

    /**
     * Prompt the user for optional input but hide the answer from the console.
     *
     * @param string $question
     * @param bool   $fallback
     *
     * @return string
     */
    public function askHiddenWithDefault($question, $fallback = true)
    {
        $question = new Question($question, 'null');

        $question->setHidden(true)->setHiddenFallback($fallback);

        return $this->output->askQuestion($question);
    }
}
