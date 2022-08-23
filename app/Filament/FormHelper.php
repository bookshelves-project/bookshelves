<?php

namespace App\Filament;

use App\Enums\MediaTypeEnum;
use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FormHelper
{
    public static function getTitle(string $field = 'title', string $label = 'Titre')
    {
        return TextInput::make($field)
            ->label($label)
            ->helperText('Génère le titre en SEO et le métalien, uniquement à la création.')
            ->required()
            ->reactive()
            ->afterStateUpdated(FormHelper::updateOnlyOn(['slug', 'meta_title']))
        ;
    }

    /**
     * @param string $current_action 'create' or 'edit'
     *
     * @return Closure
     */
    public static function disabledOn(string $current_action)
    {
        return function (mixed $livewire) use ($current_action) {
            $class = get_class($livewire);
            $class = explode('\\', $class);
            $action = $class[sizeof($class) - 1];

            if (str_contains(strtolower($action), $current_action)) {
                return true;
            }
        };
    }

    public static function updateOnlyOn(string|array $field, bool $onCreate = true)
    {
        return function (mixed $livewire, Closure $set, ?string $state) use ($field, $onCreate) {
            $class = get_class($livewire);
            $class = explode('\\', $class);
            $action = $class[sizeof($class) - 1];

            if (! str_contains($action, $onCreate ? 'Edit' : 'Update')) {
                if (is_array($field)) {
                    foreach ($field as $value) {
                        $set($value, $state);
                    }
                } else {
                    $set($field, $state);
                }
            }
        };
    }

    public static function getSeo(string $model)
    {
        return [
            Placeholder::make('seo')
                ->label('SEO'),
            TextInput::make('slug')
                ->label('Metalien')
                ->required()
                ->unique($model, 'slug', fn ($record) => $record),
            TextInput::make('meta_title')
                ->label('Titre'),
            Textarea::make('meta_description')
                ->label('Description'),
        ];
    }

    public static function getDateFilter(string $field = 'created_at')
    {
        return Filter::make('created_at')
            ->form([
                DatePicker::make('created_from')
                    ->label('Publié depuis le')
                    ->placeholder(fn ($state): string => now()->subYear()->format('M d, Y')),
                DatePicker::make('created_until')
                    ->label("Publié jusqu'au")
                    ->placeholder(fn ($state): string => now()->format('M d, Y')),
            ])
            ->query(
                fn (Builder $query, array $data): Builder => $query
                    ->when(
                        $data['created_from'],
                        fn (Builder $query, $date): Builder => $query->whereDate($field, '>=', $date),
                    )
                    ->when(
                        $data['created_until'],
                        fn (Builder $query, $date): Builder => $query->whereDate($field, '<=', $date),
                    )
            )
        ;
    }

    public static function checkRole(UserRole $role = UserRole::super_admin)
    {
        return function () use ($role) {
            /** @var User */
            $user = auth()->user();

            return $user->role->value !== $role->value;
        };
    }

    public static function getImageField(
        string $field = 'image',
        string $label = 'Image',
        MediaTypeEnum $type = MediaTypeEnum::media,
        array $fileTypes = [
            'image/jpeg',
            'image/webp',
            'image/png',
            'image/svg+xml',
        ],
        string $hint = 'Accepte JPG, WEBP, PNG, SVG'
    ) {
        return FileUpload::make($field)
            ->label($label)
            ->hint($hint)
            ->acceptedFileTypes($fileTypes)
            ->image()
            ->maxSize(1024)
            ->directory($type->name)
        ;
    }

    public static function showAction()
    {
        return Action::make('show')
            ->url(fn ($record): string => "{$record->show_live}")
            ->icon('heroicon-o-eye')
            ->openUrlInNewTab()
            ->color('warning')
            ->label('Voir')
        ;
    }
}
