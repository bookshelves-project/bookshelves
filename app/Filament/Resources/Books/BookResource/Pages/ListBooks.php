<?php

namespace App\Filament\Resources\Books\BookResource\Pages;

use App\Filament\Resources\Books\BookResource;
use App\Jobs\SyncBooks;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListBooks extends ListRecords
{
    protected static string $resource = BookResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Actions\Action::make('sync')
                ->icon('heroicon-o-arrow-path')
                ->label('Synchronize')
                ->outlined()
                ->requiresConfirmation()
                ->modalHeading('Sync books')
                ->modalDescription("It will parse books files to find new books and update existing ones with assets and relations. It's will be take some time, you can close this page, you will receive a notification on notification panel when it's done.")
                ->modalSubmitActionLabel('Sync')
                ->action(function () {
                    SyncBooks::dispatch(recipient: auth()->user());
                    Notification::make()
                        ->title('Sync is started')
                        ->body('Books and relations will be updated in background, you can close this window.')
                        ->icon('heroicon-o-arrow-path')
                        ->iconColor('success')
                        ->send();
                }),
            Actions\Action::make('sync-fresh')
                ->icon('heroicon-o-arrow-path')
                ->label('Synchronize (refresh)')
                ->color('danger')
                ->outlined()
                ->requiresConfirmation()
                ->modalHeading('Sync fresh books')
                ->modalDescription('Same action than sync but all books will be deleted and re-recreated (favorites and reviews will be deleted).')
                ->modalSubmitActionLabel('Sync')
                ->action(function () {
                    SyncBooks::dispatch(fresh: true, recipient: auth()->user());
                    Notification::make()
                        ->title('Sync fresh is started')
                        ->body('Books and relations will be deleted and refreshed in background, you can close this window.')
                        ->icon('heroicon-o-arrow-path')
                        ->iconColor('danger')
                        ->send();
                }),
            // Actions\Action::make('upload')
            //     ->label('Upload new books')
            //     ->url(route('admin.upload'))
            //     ->openUrlInNewTab(),
        ];
    }

    // protected function getTableRecordsPerPageSelectOptions(): array
    // {
    //     return [25, 50, 100];
    // }
}
