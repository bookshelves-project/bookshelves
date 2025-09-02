<?php

namespace App\Filament\Widgets;

use App\Console\Commands\Bookshelves\AnalyzeCommand;
use App\Jobs\AnalyzeJob;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Kiwilan\Steward\Commands\Scout\ScoutFreshCommand;
use Kiwilan\Steward\Jobs\LogClearJob;

class InfoWidget extends Widget implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected static ?int $sort = -2;

    protected static bool $isLazy = false;

    /**
     * @var view-string
     */
    protected static string $view = 'widgets.info-widget';

    public function makeFilamentTranslatableContentDriver(): ?TranslatableContentDriver
    {
        return null;
    }

    public function analyzeAction(): Action
    {
        return Action::make('analyze')
            ->label('Analyze')
            ->icon('heroicon-o-magnifying-glass')
            ->outlined()
            ->action(function () {
                Notification::make()
                    ->title('Analyze')
                    ->body('Start analyze command...')
                    ->info()
                    ->send();
                // Artisan::call(AnalyzeCommand::class);
                AnalyzeJob::dispatch();
            });
    }

    public function scoutRefreshAction(): Action
    {
        return Action::make('scout-refresh')
            ->label('Scout refresh')
            ->icon('heroicon-o-magnifying-glass-circle')
            ->outlined()
            ->action(function () {
                Notification::make()
                    ->title('Scout refresh')
                    ->body('Start scout refresh...')
                    ->info()
                    ->send();
                Artisan::call(ScoutFreshCommand::class);
            });
    }

    public function logsViewerAction(): Action
    {
        return Action::make('logs-viewer')
            ->label('Logs viewer')
            ->icon('heroicon-o-clipboard-document-list')
            ->outlined()
            ->url(route('log-viewer.index'))
            ->openUrlInNewTab();
    }

    public function logsClearAction(): Action
    {
        return Action::make('logs-clear')
            ->label('Logs clear (job)')
            ->icon('heroicon-o-clipboard')
            ->outlined()
            ->action(function () {
                Notification::make()
                    ->title('Logs clear')
                    ->body('Start clear logs as job...')
                    ->info()
                    ->send();
                LogClearJob::dispatch();
            });
    }

    public function jobsCountAction(): Action
    {
        return Action::make('jobs-count')
            ->label('Jobs count')
            ->icon('heroicon-o-inbox-stack')
            ->outlined()
            ->action(function () {
                $count = DB::table('jobs')->count();
                Notification::make()
                    ->title('Jobs count')
                    ->body("There are {$count} jobs in the queue.")
                    ->info()
                    ->send();
            });
    }

    public function jobsClearAction(): Action
    {
        return Action::make('jobs')
            ->label('Jobs clear')
            ->icon('heroicon-o-inbox')
            ->outlined()
            ->action(function () {
                DB::table('jobs')->truncate();
                Notification::make()
                    ->title('Jobs clear')
                    ->body('All jobs have been cleared.')
                    ->info()
                    ->send();
            });
    }
}
