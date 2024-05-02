<?php

namespace App\Models;

use App\Enums\LibraryTypeEnum;
use App\Models\Scopes\EnabledScope;
use App\Observers\LibraryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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
        'path',
        'path_name',
        'path_is_valid',
        'is_enabled',
    ];

    protected $appends = [
        'is_audiobook',
        'is_book',
        'is_comic',
        'is_manga',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => LibraryTypeEnum::class,
            'path_is_valid' => 'boolean',
            'is_enabled' => 'boolean',
        ];
    }

    public function scopeOnlyAudiobooks(Builder $query)
    {
        return $query->where('type', LibraryTypeEnum::audiobook);
    }

    public function scopeOnlyBooks(Builder $query)
    {
        return $query->where('type', LibraryTypeEnum::book);
    }

    public function scopeOnlyComics(Builder $query)
    {
        return $query->where('type', LibraryTypeEnum::comic);
    }

    public function scopeOnlyMangas(Builder $query)
    {
        return $query->where('type', LibraryTypeEnum::manga);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_enabled', true);
    }

    public function getIsAudiobookAttribute(): bool
    {
        return $this->type == LibraryTypeEnum::audiobook;
    }

    public function getIsBookAttribute(): bool
    {
        return $this->type == LibraryTypeEnum::book;
    }

    public function getIsComicAttribute(): bool
    {
        return $this->type == LibraryTypeEnum::comic;
    }

    public function getIsMangaAttribute(): bool
    {
        return $this->type == LibraryTypeEnum::manga;
    }

    protected static function countType(Collection $collection): int
    {
        $count = 0;
        foreach ($collection as $library) {
            $path = $library->getJsonPath();
            if (file_exists($path)) {
                $json = json_decode(file_get_contents($path), true);
                $count += count($json);
            }
        }

        return $count;
    }

    public static function getAudiobooksCount(): int
    {
        return self::countType(Library::onlyAudiobooks()->get());
    }

    public static function getBooksCount(): int
    {
        return self::countType(Library::onlyBooks()->get());
    }

    public static function getComicsCount(): int
    {
        return self::countType(Library::onlyComics()->get());
    }

    public static function getMangasCount(): int
    {
        return self::countType(Library::onlyMangas()->get());
    }

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

    public function books(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Book::class);
    }

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
