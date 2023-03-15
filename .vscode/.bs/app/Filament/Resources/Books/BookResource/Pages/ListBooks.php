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
                ->icon('heroicon-o-refresh')
                ->label('Sync')
                ->requiresConfirmation()
                ->modalHeading('Sync books')
                ->modalSubheading("It will parse books files to find new books and update existing ones with assets and relations. It's will be take some time, you can close this page, you will receive a notification on notification panel when it's done.")
                ->modalButton('Sync')
                ->action(function () {
                    ProcessSyncBooks::dispatch(recipient: auth()->user());
                    Notification::make()
                        ->title('Sync is started')
                        ->body('Books and relations will be updated in background, you can close this window.')
                        ->icon('heroicon-o-refresh')
                        ->iconColor('success')
                        ->send()
                    ;
                }),
            Actions\Action::make('sync-fresh')
                ->icon('heroicon-o-refresh')
                ->label('Sync (fresh)')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Sync fresh books')
                ->modalSubheading('Same action than sync but all books will be deleted and re-recreated (favorites and reviews will be deleted).')
                ->modalButton('Sync')
                ->action(function () {
                    ProcessSyncBooks::dispatch(fresh: true, recipient: auth()->user());
                    Notification::make()
                        ->title('Sync fresh is started')
                        ->body('Books and relations will be deleted and refreshed in background, you can close this window.')
                        ->icon('heroicon-o-refresh')
                        ->iconColor('danger')
                        ->send()
                    ;
                }),
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
