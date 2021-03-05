<?php

namespace App\Console\Commands;

use File;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
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
    protected $urlLocal = 'http://api.bookshelves.test';
    protected $urlProd = 'https://bookshelves.git-projects.xyz';

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
        $this->appNameSlug = Str::slug($this->appName);
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

        $this->warn("\n".'Choose mode:');
        $prod = false;

        // .env file
        $this->info('Config .env...');
        $requestCreateEnv = $this->createEnvFile();
        if ($requestCreateEnv) {
            $credentials = $this->requestDatabaseCredentials();
            $this->updateEnvironmentFile($credentials);
            $this->cleaning();
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
        // npm install
        $this->info('Node.js dependencies installation...');
        exec('yarn');
        if ($prod) {
            exec('yarn prod');
        } else {
            exec('yarn dev');
        }
        // migration
        $this->info('Database migration...');
        if ($this->confirm('Do you want to migrate database?', true)) {
            Artisan::call('migrate --force');

            $this->line('~ Database successfully migrated.');

            if ($this->confirm('Do you want to migrate fresh database with seeds?', false)) {
                Artisan::call('migrate:fresh --seed --force');

                $this->line('~ Database successfully migrated with seeds.');
            }
        }
        if ($this->confirm('Do you want to make directory public/storage/books-raw?', true)) {
            $path = 'public/storage/books-raw';
            if (! is_dir($path)) {
                mkdir($path);
            }
        }
        // clean
        Artisan::call('key:generate');
        $this->warn('~ Secret key properly generated.');
        if ($this->confirm('Do you want to generate books?', false)) {
            $command = 'books:generate -fF';
            Artisan::call($command, [], $this->getOutput());
        }
        $this->info('Cleaning...');
        if ($prod) {
            $this->cleaningProd();
        } else {
            $this->cleaningDev();
        }
        $this->info('Application is ready!');

        $this->info("\n");
        $this->goodbye();
    }

    /**
     * Update the .env file from an array of $key => $value pairs.
     *
     * @param array $updatedValues
     *
     * @return void
     */
    protected function updateEnvironmentFile(array $updatedValues)
    {
        $envFile = base_path('.env');

        foreach ($updatedValues as $key => $value) {
            file_put_contents($envFile, preg_replace(
                "/{$key}=(.*)/",
                "{$key}={$value}",
                file_get_contents($envFile)
            ));
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
            'APP_ENV'   => $this->ask('Environnement', 'production'),
            // 'APP_DEBUG' => $this->ask('Debug', 'false'),
            'APP_URL'                 => $this->ask('Application URL', $this->urlProd),
        ];
    }

    protected function setupLocal()
    {
        return [
            'APP_URL'                 => $this->ask('Application URL', $this->urlLocal),
        ];
    }

    /**
     * Request the local database details from the user.
     *
     * @return array
     */
    protected function requestDatabaseCredentials()
    {
        // TODO
        // MAIL_HOST=smtp.mailtrap.io
        // MAIL_PORT=2525
        // MAIL_USERNAME=16a36c1ca81e03
        // MAIL_PASSWORD=d49144dd24808d

        // L5_SWAGGER_GENERATE_ALWAYS=true

        // SANCTUM_STATEFUL_DOMAINS=localhost:3000
        // SESSION_DOMAIN=localhost

        // TELESCOPE_ENABLED=false

        // RECAPTCHA_SITE_KEY=6LfX4FcaAAAAABBdKY7HFoyzlFUceUVIIA5L6ANQ
        // RECAPTCHA_SECRET_KEY=6LfX4FcaAAAAAIcm0HfFTi4H76BltoRy9QrGM1CQ
        //
        return [
            'APP_NAME'                => $this->ask('App name', $this->appName),
            'DB_DATABASE'             => $this->ask('Database name', $this->appNameSlug),
            'DB_PORT'                 => $this->ask('Database port', '3306'),
            'DB_USERNAME'             => $this->ask('Database user', 'root'),
            'DB_PASSWORD'             => $this->askHiddenWithDefault('Database password (leave blank for no password)'),
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
