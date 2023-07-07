<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Health;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\MeiliSearchCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\PingCheck;
use Spatie\Health\Checks\Checks\QueueCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Model::preventLazyLoading(! app()->isProduction());

        // Filament::serving(function () {
        //     Filament::registerViteTheme('resources/assets/css/filament.css');
        // });

        // // View::addNamespace('app', resource_path());

        // if ('local' !== config('app.env')) {
        //     LogViewer::auth(function ($request) {
        //         $user = $request->user();

        //         return $user->is_admin || $user->is_super_admin;
        //     });
        // }

        // https://laravel.com/docs/10.x/eloquent-relationships#preventing-lazy-loading
        Model::preventLazyLoading(! $this->app->environment('production'));

        LogViewer::auth(function (Request $request) {
            // if (! $this->app->environment('production')) {
            //     return true;
            // }

            // $user = Auth::user();

            // if (! $user) {
            //     return false;
            // }

            // return $user->is_admin || $user->is_super_admin;
            return true;
        });

        View::addNamespace('webreader', resource_path('webreader'));

        Queue::after(function (JobProcessed $event) {
            $payload = $event->job->payload();
            $uuid = $payload['uuid'] ?? null;
            $data = $payload['data'] ?? null;

            $commandName = null;
            $command = null;

            if ($data) {
                $commandName = $data['commandName'] ?? null;
                $command = $data['command'] ?? null;
            }

            if ($event->job->hasFailed()) {
                Log::warning('Job failed', [
                    'uuid' => $uuid,
                    'data' => [
                        'commandName' => $commandName,
                        'command' => $command,
                    ],
                ]);
            } else {
                Log::info('Job processed', [
                    'uuid' => $uuid,
                    'data' => [
                        'commandName' => $commandName,
                        'command' => $command,
                    ],
                ]);
            }
        });

        // Use `Refresh` button to refresh the page
        Health::checks([
            OptimizedAppCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
            CacheCheck::new(),
            DatabaseCheck::new(),
            MeiliSearchCheck::new(),
            PingCheck::new()->url(config('app.url')),
            QueueCheck::new(),
            // RedisCheck::new(),
            ScheduleCheck::new(),
            UsedDiskSpaceCheck::new(),
            // HorizonCheck::new(),
            // SecurityAdvisoriesCheck::new(), // composer require spatie/security-advisories-health-check
            // CpuLoadCheck::new() // composer require spatie/cpu-load-health-check
            //     ->failWhenLoadIsHigherInTheLast5Minutes(2.0)
            //     ->failWhenLoadIsHigherInTheLast15Minutes(1.5),
            // DatabaseConnectionCountCheck::new() // composer require doctrine/dbal
            //     ->failWhenMoreConnectionsThan(100)
            // DatabaseTableSizeCheck::new() // composer require doctrine/dbal
            //     ->table('your_table_name', maxSizeInMb: 1_000)
            //     ->table('another_table_name', maxSizeInMb: 2_000),
        ]);

        Filament::serving(function () {
            Filament::registerViteTheme('resources/css/filament.css');
            Filament::registerNavigationItems([
                NavigationItem::make('Analytics')
                    ->url('https://matomo.git-projects.xyz', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->activeIcon('heroicon-s-presentation-chart-line')
                    ->group('Settings')
                    ->sort(1),
                NavigationItem::make('Documentation')
                    ->url('/docs', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-information-circle')
                    ->activeIcon('heroicon-s-information-circle')
                    ->group('Settings')
                    ->sort(1),
                NavigationItem::make('Log viewer')
                    ->url('/log-viewer', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-chat')
                    ->activeIcon('heroicon-s-chat')
                    ->group('Settings')
                    ->sort(1),
            ]);
        });
    }
}
