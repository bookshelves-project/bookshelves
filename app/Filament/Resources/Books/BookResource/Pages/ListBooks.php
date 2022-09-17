<?php

namespace App\Filament\Resources\Books\BookResource\Pages;

use App\Filament\Resources\Books\BookResource;
use App\Jobs\ProcessSyncBooks;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBooks extends ListRecords
{
    protected static string $resource = BookResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Actions\Action::make('sync')
                ->label('Sync books')
                ->icon('heroicon-o-refresh')
                ->action(function () {
                    ProcessSyncBooks::dispatch();
                    Notification::make()
                        ->title('Sync started, books and relations will be updated in background.')
                        ->success()
                        ->send()
                    ;
                })
                ->requiresConfirmation()
                ->modalHeading('Sync books')
                ->modalSubheading("This is a safe action, it will parse books to find new books and update existing ones with assets and relations. It's will be take some time, you can close this page. Progression can be checked in logs accessible from dashboard.")
                ->modalButton('Sync now'),
            Actions\Action::make('fresh')
                ->label('Fresh sync')
                ->color('warning')
                ->icon('heroicon-o-refresh')
                ->action(function () {
                    ProcessSyncBooks::dispatch(true);
                    Notification::make()
                        ->title('Fresh sync started, books and relations will be updated in background.')
                        ->success()
                        ->send()
                    ;
                })
                ->requiresConfirmation()
                ->modalHeading('Fresh sync books')
                ->modalSubheading("This action will sync all books but with fresh option. All existing books will be DELETED and RE-CREATED, favorites and comments will be deleted. It's will be take some time, you can close this page. Progression can be checked in logs accessible from dashboard.")
                ->modalButton('Fresh sync now'),
            Actions\Action::make('upload')
                ->label('Upload new books')
                ->url(route('admin.upload'))
                ->openUrlInNewTab(),
        ];
    }

    // protected function getTableRecordsPerPageSelectOptions(): array
    // {
    //     return [25, 50, 100];
    // }
}
