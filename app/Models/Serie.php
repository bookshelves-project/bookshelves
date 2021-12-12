<?php

namespace App\Models;

use App\Models\Traits\HasAuthors;
use App\Models\Traits\HasClassName;
use App\Models\Traits\HasComments;
use App\Models\Traits\HasCovers;
use App\Models\Traits\HasFavorites;
use App\Models\Traits\HasLanguage;
use App\Models\Traits\HasSelections;
use App\Models\Traits\HasTagsAndGenres;
use App\Models\Traits\HasWikipediaItem;
use App\Utils\BookshelvesTools;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Tags\HasTags;

/**
 * App\Models\Serie.
 *
 * @property int                                                                                                                           $id
 * @property null|string                                                                                                                   $title
 * @property null|string                                                                                                                   $title_sort
 * @property null|string                                                                                                                   $slug
 * @property null|string                                                                                                                   $language_slug
 * @property null|string                                                                                                                   $description
 * @property null|string                                                                                                                   $link
 * @property null|int                                                                                                                      $wikipedia_item_id
 * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
 * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
 * @property \App\Models\Author[]|\Illuminate\Database\Eloquent\Collection                                                                 $authors
 * @property null|int                                                                                                                      $authors_count
 * @property \App\Models\Book[]|\Illuminate\Database\Eloquent\Collection                                                                   $books
 * @property null|int                                                                                                                      $books_count
 * @property \App\Models\Comment[]|\Illuminate\Database\Eloquent\Collection                                                                $comments
 * @property null|int                                                                                                                      $comments_count
 * @property \App\Models\User[]|\Illuminate\Database\Eloquent\Collection                                                                   $favorites
 * @property null|int                                                                                                                      $favorites_count
 * @property string                                                                                                                        $authors_names
 * @property string                                                                                                                        $content_opds
 * @property null|string                                                                                                                   $cover_color
 * @property null|string                                                                                                                   $cover_og
 * @property null|string                                                                                                                   $cover_original
 * @property null|string                                                                                                                   $cover_simple
 * @property null|string                                                                                                                   $cover_thumbnail
 * @property string                                                                                                                        $download_link
 * @property mixed                                                                                                                         $genres_list
 * @property bool                                                                                                                          $is_favorite
 * @property null|string                                                                                                                   $meta_author
 * @property string                                                                                                                        $show_books_link
 * @property string                                                                                                                        $show_link
 * @property string                                                                                                                        $show_link_opds
 * @property string                                                                                                                        $size
 * @property mixed                                                                                                                         $tags_list
 * @property string                                                                                                                        $webreader_link
 * @property null|\App\Models\Language                                                                                                     $language
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property null|int                                                                                                                      $media_count
 * @property \App\Models\User[]|\Illuminate\Database\Eloquent\Collection                                                                   $selections
 * @property null|int                                                                                                                      $selections_count
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[]                                                                   $tags
 * @property null|int                                                                                                                      $tags_count
 * @property null|\App\Models\WikipediaItem                                                                                                $wikipedia
 *
 * @method static \Database\Factories\SerieFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereAuthorIsLike(string $author)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereLanguageSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereLanguagesIs($languages)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTagsAllIs($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTagsIs($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTitleSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereWikipediaItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie withAllTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie withAnyTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie withAnyTagsOfAnyType($tags)
 * @mixin \Eloquent
 */
class Serie extends Model implements HasMedia
{
    use HasFactory;
    use HasTags;
    use HasClassName;
    use HasCovers;
    use HasAuthors;
    use HasFavorites;
    use HasComments;
    use HasSelections;
    use HasLanguage;
    use HasTagsAndGenres;
    use Searchable;
    use HasWikipediaItem;

    protected $fillable = [
        'title',
        'title_sort',
        'slug',
        'description',
        'link',
    ];

    protected $with = [
        'language',
        'authors',
        'media',
    ];

    public function getContentOpdsAttribute(): string
    {
        return $this->books->count().' books';
    }

    public function getShowBooksLinkAttribute(): string
    {
        return route('api.series.show.books', [
            'author' => $this->meta_author,
            'serie' => $this->slug,
        ]);
    }

    public function getSizeAttribute(): string
    {
        $size = [];
        $serie = Serie::whereSlug($this->slug)->with('books.media')->first();
        $books = $serie->books;
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
            'title' => $this->title,
            'picture' => $this->cover_thumbnail,
            'author' => $this->authors_names,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Get Books into Serie, by volume order.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class)->orderBy('volume');
    }
}
