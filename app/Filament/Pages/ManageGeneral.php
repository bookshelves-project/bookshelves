<?php

namespace App\Filament\Pages;

use App\Jobs\ProcessFavicon;
use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Pages\SettingsPage;
use Kiwilan\Steward\Enums\BuilderEnum\BuilderSocialEnum;
use Kiwilan\Steward\Enums\LanguageEnum;
use Kiwilan\Steward\Filament\Config\FilamentBuilder\Generator\DateTimeZoneBuilder;
use Kiwilan\Steward\Filament\Config\FilamentLayout;
use Livewire\TemporaryUploadedFile;

class ManageGeneral extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = GeneralSettings::class;

    protected function getFormSchema(): array
    {
        return [
            FilamentLayout::setting([
                Forms\Components\TextInput::make('site_name')
                    ->label('Site name')
                    ->required(),
                Forms\Components\Toggle::make('site_active')
                    ->label('Site active')
                    ->helperText('If the site is not active, it will be unavailable to the public.')
                    ->default(true)
                    ->required(),
                Forms\Components\TextInput::make('site_url')
                    ->label('Site URL')
                    ->helperText("Can't be changed here, contact the administrator.")
                    ->default(config('app.url'))
                    ->disabled(),
                Forms\Components\Select::make('site_lang')
                    ->label('Site language')
                    ->options(LanguageEnum::toArray())
                    ->default(LanguageEnum::en->value)
                    ->required(),
                Forms\Components\Select::make('site_utc')
                    ->label('Site UTC')
                    ->options(DateTimeZoneBuilder::make())
                    ->default('utc')
                    ->required(),
                Forms\Components\Textarea::make('site_description')
                    ->label('Site description')
                    ->columnSpan([
                        'sm' => 1,
                        'lg' => 2,
                    ]),
            ])->width(2)->title('General')->get(),
            FilamentLayout::setting([
                Forms\Components\FileUpload::make('site_favicon')
                    ->label('Site favicon')
                    ->acceptedFileTypes(['image/png', 'image/svg+xml', 'image/webp'])
                    ->maxSize(512)
                    ->disk('public')
                    ->directory('settings')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $name = "favicon.{$file->getClientOriginalExtension()}";
                        ProcessFavicon::dispatch(public_path("storage/settings/{$name}"));
                        return $name;
                    }),
                Forms\Components\ColorPicker::make('site_color')
                    ->label('Site color')
                    ->default('#ffffff')
                    ->helperText("Defines the default theme color for the application. This sometimes affects how system displays the site (like on Android's task switcher, the theme color surrounds the site).")
                    ->required(),
            ])->width(2)->title('General')->get(),
            FilamentLayout::setting([
                Forms\Components\Repeater::make('social')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->options(BuilderSocialEnum::toArray())
                            ->required()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('link')
                            ->url()
                            ->required()
                            ->columnSpan(1),
                    ])
                    ->columnSpan(2)
                    ->columns([
                        'sm' => 1,
                        'lg' => 2,
                    ]),
            ])
                ->width(2)
                ->get(),
        ];
    }
}
