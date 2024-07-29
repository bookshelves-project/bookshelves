<?php

namespace App\Filament\Widgets;

use App\Console\Commands\Bookshelves\AnalyzeCommand;
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
use Kiwilan\LaravelNotifier\Facades\Journal;

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
                Journal::info('Start analyze', 'Followed commands will be executed: AnalyzeCommand.')->toDatabase();
                Artisan::call(AnalyzeCommand::class);
            });
    }

    // public function recommendationsAction(): Action
    // {
    //     return Action::make('Recommendations')
    //         ->label('Recommendations')
    //         ->icon('heroicon-o-document-magnifying-glass')
    //         ->outlined()
    //         ->action(function () {
    //             Journal::info('Start recommendations', 'Followed commands will be executed: recommendations.')->toDatabase();
    //             Artisan::call(RecommendationsCommand::class);
    //         });
    // }

    public function jobsAction(): Action
    {
        return Action::make('jobs')
            ->label('Count jobs')
            ->icon('heroicon-o-inbox-stack')
            ->outlined()
            ->action(function () {
                $count = DB::table('jobs')->count();
                Notification::make()
                    ->title('Jobs')
                    ->body("There are {$count} jobs in the queue.")
                    ->info()
                    ->send();
            });
    }
}
