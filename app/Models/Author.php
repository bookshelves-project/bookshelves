<?php

namespace App\Models;

use App\Models\Traits\HasClassName;
use App\Models\Traits\HasComments;
use App\Models\Traits\HasCovers;
use App\Models\Traits\HasFavorites;
use App\Models\Traits\HasSelections;
use App\Models\Traits\HasWikipediaItem;
use App\Utils\BookshelvesTools;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Tags\HasTags;

/**
 * App\Models\Author.
 *
 * @property int                                                                                                                           $id
 * @property null|string                                                                                                                   $slug
 * @property null|string                                                                                                                   $lastname
 * @property null|string                                                                                                                   $firstname
 * @property null|string                                                                                                                   $name
 * @property null|string                                                                                                                   $role
 * @property null|string                                                                                                                   $description
 * @property null|string                                                                                                                   $link
 * @property null|string                                                                                                                   $note
 * @property null|int                                                                                                                      $wikipedia_item_id
 * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
 * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
 * @property \App\Models\Book[]|\Illuminate\Database\Eloquent\Collection                                                                   $books
 * @property null|int                                                                                                                      $books_count
 * @property \App\Models\Comment[]|\Illuminate\Database\Eloquent\Collection                                                                $comments
 * @property null|int                                                                                                                      $comments_count
 * @property \App\Models\User[]|\Illuminate\Database\Eloquent\Collection                                                                   $favorites
 * @property null|int                                                                                                                      $favorites_count
 * @property string                                                                                                                        $content_opds
 * @property null|string                                                                                                                   $cover_color
 * @property null|string                                                                                                                   $cover_og
 * @property null|string                                                                                                                   $cover_original
 * @property null|string                                                                                                                   $cover_simple
 * @property null|string                                                                                                                   $cover_thumbnail
 * @property string                                                                                                                        $download_link
 * @property string                                                                                                                        $first_char
 * @property bool                                                                                                                          $is_favorite
 * @property string                                                                                                                        $show_books_link
 * @property string                                                                                                                        $show_link
 * @property string                                                                                                                        $show_link_opds
 * @property string                                                                                                                        $show_series_link
 * @property string                                                                                                                        $size
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property null|int                                                                                                                      $media_count
 * @property \App\Models\User[]|\Illuminate\Database\Eloquent\Collection                                                                   $selections
 * @property null|int                                                                                                                      $selections_count
 * @property \App\Models\Serie[]|\Illuminate\Database\Eloquent\Collection                                                                  $series
 * @property null|int                                                                                                                      $series_count
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[]                                                                   $tags
 * @property null|int                                                                                                                      $tags_count
 * @property null|\App\Models\WikipediaItem                                                                                                $wikipedia
 *
 * @method static \Database\Factories\AuthorFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author query()
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereWikipediaItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author withAllTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Author withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Author withAnyTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Author withAnyTagsOfAnyType($tags)
 * @mixin \Eloquent
 */
class Author extends Model implements HasMedia
{
    use HasFactory;
    use HasTags;
    use HasClassName;
    use HasCovers;
    use HasFavorites;
    use HasComments;
    use HasSelections;
    use Searchable;
    use HasWikipediaItem;

    protected $fillable = [
        'lastname',
        'firstname',
        'name',
        'slug',
        'role',
        'description',
        'link',
        'note',
    ];

    protected $with = [
        'media',
    ];

    /**
     * Retrieve the model for a bound value.
     *
     * @param mixed       $value
     * @param null|string $field
     *
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('slug', $value)->with('media')->withCount('books')->firstOrFail();
    }

    public function getShowLinkAttribute(): string
    {
        return route('api.authors.show', [
            'author' => $this->slug,
        ]);
    }

    public function getShowLinkOpdsAttribute(): string
    {
        return route('features.opds.authors.show', [
            'version' => 'v1.2',
            'author' => $this->slug,
        ]);
    }

    public function getContentOpdsAttribute(): string
    {
        return $this->books->count().' books';
    }

    public function getShowBooksLinkAttribute(): string
    {
        return route('api.authors.show.books', [
            'author' => $this->slug,
        ]);
    }

    public function getShowSeriesLinkAttribute(): string
    {
        return route('api.authors.show.series', [
            'author' => $this->slug,
        ]);
    }

    public function getDownloadLinkAttribute(): string
    {
        return route('api.download.author', [
            'author' => $this->slug,
        ]);
    }

    public function getSizeAttribute(): string
    {
        $size = [];
        $author = Author::whereSlug($this->slug)->with('books.media')->first();
        $books = $author->books;
        foreach ($books as $key => $book) {
            array_push($size, $book->getMedia('epubs')->first()?->size);
        }
        $size = array_sum($size);

        return BookshelvesTools::humanFilesize($size);
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'picture' => $this->cover_thumbnail,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function getFirstCharAttribute(): string
    {
        return strtolower($this->lastname[0]);
    }

    /**
     * Get all of the books that are assigned this author.
     */
    public function books(): MorphToMany
    {
        return $this->morphedByMany(Book::class, 'authorable')->orderBy('serie_id')->orderBy('volume');
    }

    /**
     * Get all of the series that are assigned this author.
     */
    public function series(): MorphToMany
    {
        return $this->morphedByMany(Serie::class, 'authorable')->orderBy('title_sort');
    }
}
