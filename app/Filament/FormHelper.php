<?php

namespace App\Filament;

use App\Enums\MediaTypeEnum;
use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Filament\Forms;
use Filament\Forms\Components;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Str;

class FormHelper
{
    public static function getTitle(string $field = 'title', string $label = 'Titre')
    {
        return Forms\Components\TextInput::make($field)
            ->label($label)
            ->helperText('Génère le titre en SEO et le métalien, uniquement à la création.')
            ->required()
            ->reactive()
            ->afterStateUpdated(function (string $context, Closure $set, $state) {
                if ('edit' === $context) {
                    return;
                }

                $set('slug', Str::slug($state));
                $set('meta_title', $state);
            })
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

    /**
     * Update field on context type.
     *
     * @param "create"|"edit" $context_type
     *
     * @return Closure
     */
    public static function afterStateUpdated(string|array $field, string $context_type = 'edit')
    {
        return function (string $context, Closure $set, $state) use ($field, $context_type) {
            if ($context === $context_type) {
                return;
            }

            if (is_array($field)) {
                foreach ($field as $item) {
                    $set($item, $state);
                }
            } else {
                $set($field, $state);
            }
        };
    }

    public static function getTimestamps()
    {
        return [
            Forms\Components\Placeholder::make('id')
                ->label('ID')
                ->content(fn ($record): ?string => $record?->id),
            Forms\Components\Placeholder::make('created_at')
                ->label('Created at')
                ->content(fn ($record): ?string => $record?->created_at?->diffForHumans()),
            Forms\Components\Placeholder::make('updated_at')
                ->label('Updated at')
                ->content(fn ($record): ?string => $record?->updated_at?->diffForHumans()),
        ];
    }

    public static function getSeo(string $model)
    {
        return [
            Forms\Components\Placeholder::make('seo')
                ->label('SEO'),
            Forms\Components\TextInput::make('slug')
                ->label('Metalien')
                ->required()
                ->unique($model, 'slug', fn ($record) => $record),
            Forms\Components\TextInput::make('meta_title')
                ->label('Titre'),
            Forms\Components\Textarea::make('meta_description')
                ->label('Description'),
        ];
    }

    public static function getDateFilter(string $field = 'created_at')
    {
        return Filter::make('created_at')
            ->form([
                Forms\Components\DatePicker::make('created_from')
                    ->label('Publié depuis le')
                    ->placeholder(fn ($state): string => now()->subYear()->format('M d, Y')),
                Forms\Components\DatePicker::make('created_until')
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
        return Components\FileUpload::make($field)
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
