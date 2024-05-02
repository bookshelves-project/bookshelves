<?php

namespace App\Filament\Resources\LibraryResource\Pages;

use App\Filament\Resources\LibraryResource;
use App\Models\Library;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Kiwilan\Steward\Filament\Components\ActionButton;

class ListLibraries extends ListRecords
{
    protected static string $resource = LibraryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('check-paths')
                ->label('Check paths')
                ->icon('heroicon-o-check-circle')
                ->outlined()
                ->action(function (): void {
                    Notification::make()
                        ->title('Checking paths...')
                        ->body('This action will check all paths of libraries, if any path is invalid, it will be marked as invalid.')
                        ->info()
                        ->send();

                    foreach (Library::all() as $lib) {
                        $exists = file_exists($lib->path);
                        $lib->path_is_valid = $exists;
                        $lib->saveQuietly();
                    }
                }),
            Actions\Action::make('upload')
                ->label('Upload libraries')
                ->icon('heroicon-o-arrow-up-tray')
                ->outlined()
                ->form([
                    ActionButton::make('download')
                        ->label('Download template')
                        ->download('/documents/template-libraries.json'),
                    FileUpload::make('json')
                        ->label('JSON File')
                        ->acceptedFileTypes(['application/json'])
                        ->disk('local')
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $path = storage_path("app/{$data['json']}");
                    $json = json_decode(file_get_contents($path), true);

                    foreach ($json as $library) {
                        $path = $library['path'];
                        if (User::query()->where('email', $path)->exists()) {
                            User::query()->where('email', $path)->update($path);
                        } else {
                            User::query()->create($path);
                        }
                    }

                    unlink($path);
                }),
        ];
    }
}
