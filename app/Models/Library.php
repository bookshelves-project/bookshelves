<?php

namespace App\Models;

use App\Analyzer\Enums\LibraryCategoryEnum;
use App\Analyzer\Enums\LibraryTypeEnum;
use App\Models\Scopes\EnabledScope;
use App\Observers\LibraryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Kiwilan\Steward\Traits\HasSlug;

#[ObservedBy([LibraryObserver::class])]
#[ScopedBy([EnabledScope::class])]
class Library extends Model
{
    use HasFactory;
    use HasSlug;
    use HasUlids;

    public const CACHE_KEY = 'libraries';

    protected $fillable = [
        'name',
        'type',
        'category',
        'path',
        'path_name',
        'path_is_valid',
        'is_enabled',
    ];

    protected $appends = [
        // 'is_dropzone',
        // 'is_movie',
        // 'is_tv_show',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'type' => LibraryTypeEnum::class,
            // 'category' => LibraryCategoryEnum::class,
            'path_is_valid' => 'boolean',
            'is_enabled' => 'boolean',
        ];
    }

    // public function scopeOnlyDropzone(Builder $query)
    // {
    //     return $query->where('type', LibraryTypeEnum::dropzone);
    // }

    // public function scopeOnlyMovies(Builder $query)
    // {
    //     return $query->where('type', LibraryTypeEnum::movie);
    // }

    // public function scopeOnlyTvShows(Builder $query)
    // {
    //     return $query->where('type', LibraryTypeEnum::tv_show);
    // }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_enabled', true);
    }

    // public function getIsDropzoneAttribute(): bool
    // {
    //     return $this->type == LibraryTypeEnum::dropzone;
    // }

    // public function getIsMovieAttribute(): bool
    // {
    //     return $this->type == LibraryTypeEnum::movie;
    // }

    // public function getIsTvShowAttribute(): bool
    // {
    //     return $this->type == LibraryTypeEnum::tv_show;
    // }

    // public static function getMoviesCount(): int
    // {
    //     $count = 0;
    //     foreach (Library::onlyMovies()->get() as $library) {
    //         $path = $library->getJsonPath();
    //         if (file_exists($path)) {
    //             $json = json_decode(file_get_contents($path), true);
    //             $count += count($json);
    //         }
    //     }

    //     return $count;
    // }

    // public static function getTvShowsCount(): int
    // {
    //     $count = 0;
    //     foreach (Library::onlyMovies()->get() as $library) {
    //         $path = $library->getJsonPath();
    //         if (file_exists($path)) {
    //             $json = json_decode(file_get_contents($path), true);
    //             $count += count($json);
    //         }
    //     }

    //     return $count;
    // }

    public function getJsonCount(): int
    {
        $path = $this->getJsonPath();
        if (file_exists($path)) {
            $json = json_decode(file_get_contents($path), true);

            return count($json);
        }

        return 0;
    }

    public function getJsonName(): string
    {
        return "{$this->slug}.json";
    }

    public function getJsonPath(): string
    {
        $name = $this->getJsonName();

        return storage_path("app/{$name}");
    }

    // public function files(): \Illuminate\Database\Eloquent\Relations\HasMany
    // {
    //     return $this->hasMany(File::class);
    // }

    // public function tvShows(): \Illuminate\Database\Eloquent\Relations\HasMany
    // {
    //     return $this->hasMany(TvShow::class);
    // }

    // public function movies(): \Illuminate\Database\Eloquent\Relations\HasMany
    // {
    //     return $this->hasMany(Movie::class);
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Library>
     */
    public static function cache(): \Illuminate\Database\Eloquent\Collection
    {
        $cache = Cache::get(self::CACHE_KEY);

        if ($cache) {
            return $cache;
        }

        $libraries = \App\Models\Library::query()->orderBy('name')->get();
        Cache::forever(self::CACHE_KEY, $libraries);

        return $libraries;
    }

    public static function cacheClear(): void
    {
        Cache::clear();
    }
}
