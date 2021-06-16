<?php

namespace App\Models;

use App\Utils\BookshelvesTools;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;

class Serie extends Model implements HasMedia
{
	use HasFactory;
	use InteractsWithMedia;
	use HasTags;

	protected $fillable = [
		'title',
		'title_sort',
		'slug',
		'description',
		'link',
	];

	public function registerMediaConversions(Media $media = null): void
	{
		$formatThumbnail = config('image.pictures.thumbnail');
		$formatStandard = config('image.pictures.open_graph');
		$formatSimple = config('image.pictures.simple');

		$this->addMediaConversion('thumbnail')
			->crop(Manipulations::CROP_TOP, $formatThumbnail['width'], $formatThumbnail['height'])
			->format(config('bookshelves.cover_extension'));

		$this->addMediaConversion('open_graph')
			->crop(Manipulations::CROP_CENTER, $formatStandard['width'], $formatStandard['height'])
			->format('jpg');

		$this->addMediaConversion('simple')
			->crop(Manipulations::CROP_CENTER, $formatSimple['width'], $formatSimple['height'])
			->format('jpg');
	}

	public function getImageThumbnailAttribute(): string | null
	{
		return $this->getFirstMediaUrl('series', 'thumbnail');
	}

	public function getImageOpenGraphAttribute(): string | null
	{
		return $this->getFirstMediaUrl('series', 'open_graph');
	}

	public function getImageSimpleAttribute(): string | null
	{
		return $this->getFirstMediaUrl('series', 'simple');
	}

	public function getImageOriginalAttribute(): string | null
	{
		return $this->getFirstMediaUrl('series');
	}

	public function getImageColorAttribute(): string | null
	{
		/** @var Media $media */
		$media = $this->getFirstMedia('series');

		if ($media) {
			$color = $media->getCustomProperty('color');

			return "#$color";
		}

		return null;
	}

	public function getShowLinkAttribute(): string
	{
		if ($this->author?->slug && $this->slug) {
			$route = route('api.series.show', [
				'author' => $this->author?->slug,
				'serie' => $this->slug,
			]);

			return $route;
		}

		return '';
	}

	public function getDownloadLinkAttribute(): string
	{
		$route = route('api.download.serie', [
			'author' => $this->author?->slug,
			'serie' => $this->slug,
		]);

		return $route;
	}

	public function getSizeAttribute(): string
	{
		$size = [];
		foreach ($this->books as $key => $book) {
			array_push($size, $book->getMedia('epubs')->first()?->size);
		}
		$size = array_sum($size);
		$size = BookshelvesTools::humanFilesize($size);

		return $size;
	}

	public function getTagsListAttribute()
	{
		return $this->tags()->whereType('tag')->get();
	}

	public function getGenresListAttribute()
	{
		return $this->tags()->whereType('genre')->get();
	}

	public function books(): HasMany
	{
		return $this->hasMany(Book::class)->orderBy('volume');
	}

	public function getIsFavoriteAttribute(): bool
	{
		$is_favorite = false;
		if (Auth::check()) {
			$entity = Serie::whereSlug($this->slug)->first();

			$checkIfFavorite = Serie::find($entity->id)->favorites;
			if (!sizeof($checkIfFavorite) < 1) {
				$is_favorite = true;
			}
		}

		return $is_favorite;
	}

	public function favorites(): MorphToMany
	{
		return $this->morphToMany(User::class, 'favoritable');
	}

	public function comments(): MorphMany
	{
		return $this->morphMany(Comment::class, 'commentable');
	}

	public function language(): BelongsTo
	{
		return $this->belongsTo(Language::class);
	}

	/**
	 * Authors MorphToMany.
	 */
	public function authors(): MorphToMany
	{
		return $this->morphToMany(Author::class, 'authorable');
	}

	/**
	 * First Author for router.
	 *
	 * @return Author|null
	 */
	public function getAuthorAttribute(): Author | null
	{
		return $this->morphToMany(Author::class, 'authorable')->first();
	}
}
