<?php

namespace App\Filament\Widgets;

use App\Console\Commands\Bookshelves\MakeCommand;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Artisan;
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
            ->outlined()
            ->action(function () {
                Artisan::call(MakeCommand::class);
                Journal::info('Start analyze', 'Followed commands will be executed: analyzer, parser, scan and metadata.')->toDatabase();
            });
    }
}
