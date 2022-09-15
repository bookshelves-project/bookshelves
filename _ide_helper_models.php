<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */

namespace App\Models{
    /**
     * App\Models\Author.
     *
     * @property int                                                                                                                           $id
     * @property null|string                                                                                                                   $slug
     * @property null|string                                                                                                                   $lastname
     * @property null|string                                                                                                                   $firstname
     * @property null|string                                                                                                                   $name
     * @property null|\App\Enums\AuthorRoleEnum                                                                                                $role
     * @property null|mixed                                                                                                                    $description
     * @property null|string                                                                                                                   $link
     * @property null|mixed                                                                                                                    $note
     * @property null|int                                                                                                                      $wikipedia_item_id
     * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
     * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
     * @property \App\Models\Book[]|\Illuminate\Database\Eloquent\Collection                                                                   $books
     * @property null|int                                                                                                                      $books_count
     * @property \App\Models\User[]|\Illuminate\Database\Eloquent\Collection                                                                   $favorites
     * @property null|int                                                                                                                      $favorites_count
     * @property null|\App\Models\Media|\App\Models\MediaExtended                                                                              $cover_book
     * @property null|string                                                                                                                   $cover_color
     * @property null|string                                                                                                                   $cover_og
     * @property null|string                                                                                                                   $cover_original
     * @property null|string                                                                                                                   $cover_simple
     * @property null|string                                                                                                                   $cover_thumbnail
     * @property mixed                                                                                                                         $genres_list
     * @property bool                                                                                                                          $is_favorite
     * @property array                                                                                                                         $meta
     * @property string                                                                                                                        $opds_link
     * @property mixed                                                                                                                         $reviews_link
     * @property mixed                                                                                                                         $tags_list
     * @property string                                                                                                                        $tags_string
     * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
     * @property null|int                                                                                                                      $media_count
     * @property \App\Models\Review[]|\Illuminate\Database\Eloquent\Collection                                                                 $reviews
     * @property null|int                                                                                                                      $reviews_count
     * @property \App\Models\Serie[]|\Illuminate\Database\Eloquent\Collection                                                                  $series
     * @property null|int                                                                                                                      $series_count
     * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[]                                                                   $tags
     * @property null|int                                                                                                                      $tags_count
     * @property null|\App\Models\WikipediaItem                                                                                                $wikipedia
     *
     * @method static \Database\Factories\AuthorFactory            factory(...$parameters)
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
     * @method static \Illuminate\Database\Eloquent\Builder|Author whereTagsAllIs(...$tags)
     * @method static \Illuminate\Database\Eloquent\Builder|Author whereTagsIs(...$tags)
     * @method static \Illuminate\Database\Eloquent\Builder|Author whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Author whereWikipediaItemId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Author withAllTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
     * @method static \Illuminate\Database\Eloquent\Builder|Author withAllTagsOfAnyType($tags)
     * @method static \Illuminate\Database\Eloquent\Builder|Author withAnyTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
     * @method static \Illuminate\Database\Eloquent\Builder|Author withAnyTagsOfAnyType($tags)
     */
    class Author extends \Eloquent implements \Spatie\MediaLibrary\HasMedia
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Book.
     *
     * @property int                                                                                                                           $id
     * @property string                                                                                                                        $title
     * @property null|string                                                                                                                   $slug_sort
     * @property null|string                                                                                                                   $slug
     * @property null|string                                                                                                                   $contributor
     * @property null|string                                                                                                                   $description
     * @property null|\Illuminate\Support\Carbon                                                                                               $released_on
     * @property null|string                                                                                                                   $rights
     * @property null|int                                                                                                                      $serie_id
     * @property null|int                                                                                                                      $volume
     * @property null|int                                                                                                                      $publisher_id
     * @property null|string                                                                                                                   $language_slug
     * @property null|int                                                                                                                      $google_book_id
     * @property null|int                                                                                                                      $page_count
     * @property null|string                                                                                                                   $maturity_rating
     * @property bool                                                                                                                          $is_disabled
     * @property \App\Enums\BookTypeEnum                                                                                                       $type
     * @property null|string                                                                                                                   $isbn10
     * @property null|string                                                                                                                   $isbn13
     * @property null|array                                                                                                                    $identifiers
     * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
     * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
     * @property \App\Models\Author[]|\Illuminate\Database\Eloquent\Collection                                                                 $authors
     * @property null|int                                                                                                                      $authors_count
     * @property \App\Models\User[]|\Illuminate\Database\Eloquent\Collection                                                                   $favorites
     * @property null|int                                                                                                                      $favorites_count
     * @property \App\Models\Author                                                                                                            $author
     * @property string                                                                                                                        $authors_names
     * @property null|\App\Models\Media|\App\Models\MediaExtended                                                                              $cover_book
     * @property null|string                                                                                                                   $cover_color
     * @property null|string                                                                                                                   $cover_og
     * @property null|string                                                                                                                   $cover_original
     * @property null|string                                                                                                                   $cover_simple
     * @property null|string                                                                                                                   $cover_thumbnail
     * @property \App\Models\Media\DownloadFile                                                                                                $file_main
     * @property \App\Models\MediaExtended[]|null[]                                                                                            $files
     * @property \App\Models\Media\DownloadFile[]                                                                                              $files_list
     * @property mixed                                                                                                                         $genres_list
     * @property bool                                                                                                                          $is_favorite
     * @property null|string                                                                                                                   $isbn
     * @property array                                                                                                                         $meta
     * @property null|string                                                                                                                   $meta_author
     * @property string                                                                                                                        $opds_link
     * @property mixed                                                                                                                         $reviews_link
     * @property mixed                                                                                                                         $tags_list
     * @property string                                                                                                                        $tags_string
     * @property null|\App\Models\GoogleBook                                                                                                   $googleBook
     * @property null|\App\Models\Language                                                                                                     $language
     * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
     * @property null|int                                                                                                                      $media_count
     * @property null|\App\Models\Publisher                                                                                                    $publisher
     * @property \App\Models\Review[]|\Illuminate\Database\Eloquent\Collection                                                                 $reviews
     * @property null|int                                                                                                                      $reviews_count
     * @property \App\Models\User[]|\Illuminate\Database\Eloquent\Collection                                                                   $selections
     * @property null|int                                                                                                                      $selections_count
     * @property null|\App\Models\Serie                                                                                                        $serie
     * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[]                                                                   $tags
     * @property null|int                                                                                                                      $tags_count
     *
     * @method static \Illuminate\Database\Eloquent\Builder|Book available()
     * @method static \Database\Factories\BookFactory            factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Book publishedBetween(string $startDate, string $endDate)
     * @method static \Illuminate\Database\Eloquent\Builder|Book query()
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthorIsLike(string $author)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereContributor($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereDisallowSerie(string $has_not_serie)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereGoogleBookId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereIdentifiers($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsDisabled($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsbn10($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsbn13($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereLanguageSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereLanguagesIs(...$languages)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereMaturityRating($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book wherePageCount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book wherePublisherId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereReleasedOn($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereRights($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereSerieId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereSlugSort($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereTagsAllIs(...$tags)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereTagsIs(...$tags)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereTypesIs(...$types)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book whereVolume($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Book withAllTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
     * @method static \Illuminate\Database\Eloquent\Builder|Book withAllTagsOfAnyType($tags)
     * @method static \Illuminate\Database\Eloquent\Builder|Book withAnyTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
     * @method static \Illuminate\Database\Eloquent\Builder|Book withAnyTagsOfAnyType($tags)
     */
    class Book extends \Eloquent implements \Spatie\MediaLibrary\HasMedia
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Page.
     *
     * @property int                                                                                                                           $id
     * @property string                                                                                                                        $title
     * @property string                                                                                                                        $slug
     * @property \App\Enums\LanguageEnum                                                                                                       $language
     * @property \App\Enums\TemplateEnum                                                                                                       $template
     * @property null|array                                                                                                                    $content
     * @property null|string                                                                                                                   $meta_title
     * @property null|string                                                                                                                   $meta_description
     * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
     * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
     * @property array                                                                                                                         $meta
     * @property null|string                                                                                                                   $route_show
     * @property array                                                                                                                         $seo
     * @property null|array                                                                                                                    $template_transform
     * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
     * @property null|int                                                                                                                      $media_count
     *
     * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Page query()
     * @method static \Illuminate\Database\Eloquent\Builder|Page whereContent($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Page whereLanguage($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Page whereMetaDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Page whereMetaTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Page whereTemplate($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Page whereTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
     */
    class Page extends \Eloquent implements \Spatie\MediaLibrary\HasMedia
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Post.
     *
     * @property int                                                                                                                           $id
     * @property string                                                                                                                        $title
     * @property string                                                                                                                        $slug
     * @property null|string                                                                                                                   $summary
     * @property null|string                                                                                                                   $body
     * @property bool                                                                                                                          $is_pinned
     * @property null|\App\Enums\PostCategoryEnum                                                                                              $category
     * @property null|\Illuminate\Support\Carbon                                                                                               $published_at
     * @property \App\Enums\PublishStatusEnum                                                                                                  $status
     * @property null|string                                                                                                                   $meta_title
     * @property null|string                                                                                                                   $meta_description
     * @property null|int                                                                                                                      $user_id
     * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
     * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
     * @property array                                                                                                                         $seo
     * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
     * @property null|int                                                                                                                      $media_count
     * @property null|\App\Models\User                                                                                                         $user
     *
     * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Post published()
     * @method static \Illuminate\Database\Eloquent\Builder|Post query()
     * @method static \Illuminate\Database\Eloquent\Builder|Post whereBody($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Post whereCategory($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsPinned($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Post whereMetaDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Post whereMetaTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Post whereStatus($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Post whereSummary($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Post whereUserId($value)
     */
    class Post extends \Eloquent implements \Spatie\MediaLibrary\HasMedia
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Favoritable.
     *
     * @property int                                           $user_id
     * @property int                                           $favoritable_id
     * @property string                                        $favoritable_type
     * @property null|\Illuminate\Support\Carbon               $created_at
     * @property null|\Illuminate\Support\Carbon               $updated_at
     * @property \Eloquent|\Illuminate\Database\Eloquent\Model $favoritable
     *
     * @method static \Illuminate\Database\Eloquent\Builder|Favoritable newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Favoritable newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Favoritable query()
     * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereFavoritableId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereFavoritableType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereUserId($value)
     */
    class Favoritable extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\GoogleBook.
     *
     * @property int                             $id
     * @property null|string                     $original_isbn
     * @property null|string                     $url
     * @property null|string                     $published_date
     * @property null|string                     $description
     * @property null|array                      $industry_identifiers
     * @property null|int                        $page_count
     * @property null|array                      $categories
     * @property null|string                     $maturity_rating
     * @property null|string                     $language
     * @property null|string                     $preview_link
     * @property null|string                     $publisher
     * @property null|int                        $retail_price_amount
     * @property null|int                        $retail_price_currency_code
     * @property null|string                     $buy_link
     * @property null|string                     $isbn10
     * @property null|string                     $isbn13
     * @property null|\Illuminate\Support\Carbon $created_at
     * @property null|\Illuminate\Support\Carbon $updated_at
     * @property null|\App\Models\Book           $book
     *
     * @method static \Database\Factories\GoogleBookFactory            factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook query()
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereBuyLink($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereCategories($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereIndustryIdentifiers($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereIsbn10($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereIsbn13($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereLanguage($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereMaturityRating($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereOriginalIsbn($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook wherePageCount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook wherePreviewLink($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook wherePublishedDate($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook wherePublisher($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereRetailPriceAmount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereRetailPriceCurrencyCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereUrl($value)
     */
    class GoogleBook extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Language.
     *
     * @property string                                                       $slug
     * @property null|array                                                   $name
     * @property null|\Illuminate\Support\Carbon                              $created_at
     * @property null|\Illuminate\Support\Carbon                              $updated_at
     * @property \App\Models\Book[]|\Illuminate\Database\Eloquent\Collection  $books
     * @property null|int                                                     $books_count
     * @property \App\Models\Serie[]|\Illuminate\Database\Eloquent\Collection $series
     * @property null|int                                                     $series_count
     *
     * @method static \Database\Factories\LanguageFactory            factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Language query()
     * @method static \Illuminate\Database\Eloquent\Builder|Language whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Language whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Language whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Language whereUpdatedAt($value)
     */
    class Language extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\MediaExtended.
     *
     * @property int                                           $id
     * @property string                                        $model_type
     * @property int                                           $model_id
     * @property null|string                                   $uuid
     * @property string                                        $collection_name
     * @property string                                        $name
     * @property string                                        $file_name
     * @property null|string                                   $mime_type
     * @property string                                        $disk
     * @property null|string                                   $conversions_disk
     * @property int                                           $size
     * @property array                                         $manipulations
     * @property array                                         $custom_properties
     * @property array                                         $generated_conversions
     * @property array                                         $responsive_images
     * @property null|int                                      $order_column
     * @property null|\Illuminate\Support\Carbon               $created_at
     * @property null|\Illuminate\Support\Carbon               $updated_at
     * @property null|string                                   $download
     * @property null|string                                   $full_extension
     * @property null|string                                   $size_human
     * @property \Eloquent|\Illuminate\Database\Eloquent\Model $model
     *
     * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|static[] all($columns = ['*'])
     * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|static[] get($columns = ['*'])
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Media                                       ordered()
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               query()
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereCollectionName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereConversionsDisk($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereCustomProperties($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereDisk($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereFileName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereGeneratedConversions($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereManipulations($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereMimeType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereModelId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereModelType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereOrderColumn($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereResponsiveImages($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereSize($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended                               whereUuid($value)
     */
    class MediaExtended extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Publisher.
     *
     * @property int                                                         $id
     * @property null|string                                                 $slug
     * @property null|string                                                 $name
     * @property null|\Illuminate\Support\Carbon                             $created_at
     * @property null|\Illuminate\Support\Carbon                             $updated_at
     * @property \App\Models\Book[]|\Illuminate\Database\Eloquent\Collection $books
     * @property null|int                                                    $books_count
     *
     * @method static \Database\Factories\PublisherFactory            factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|Publisher newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Publisher newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Publisher query()
     * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereUpdatedAt($value)
     */
    class Publisher extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Review.
     *
     * @property int                                                           $id
     * @property null|string                                                   $text
     * @property null|int                                                      $rating
     * @property null|int                                                      $user_id
     * @property null|int                                                      $reviewable_id
     * @property null|string                                                   $reviewable_type
     * @property null|\Illuminate\Support\Carbon                               $created_at
     * @property null|\Illuminate\Support\Carbon                               $updated_at
     * @property \App\Models\Author[]|\Illuminate\Database\Eloquent\Collection $authors
     * @property null|int                                                      $authors_count
     * @property \App\Models\Book[]|\Illuminate\Database\Eloquent\Collection   $books
     * @property null|int                                                      $books_count
     * @property \Eloquent|\Illuminate\Database\Eloquent\Model                 $reviewable
     * @property \App\Models\Serie[]|\Illuminate\Database\Eloquent\Collection  $series
     * @property null|int                                                      $series_count
     * @property null|\App\Models\User                                         $user
     *
     * @method static \Database\Factories\ReviewFactory            factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Review query()
     * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Review whereRating($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Review whereReviewableId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Review whereReviewableType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Review whereText($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Review whereUserId($value)
     */
    class Review extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Selectionable.
     *
     * @property int                             $id
     * @property int                             $user_id
     * @property int                             $selectionable_id
     * @property string                          $selectionable_type
     * @property null|\Illuminate\Support\Carbon $created_at
     * @property null|\Illuminate\Support\Carbon $updated_at
     *
     * @method static \Database\Factories\SelectionableFactory            factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|Selectionable newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Selectionable newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Selectionable query()
     * @method static \Illuminate\Database\Eloquent\Builder|Selectionable whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Selectionable whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Selectionable whereSelectionableId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Selectionable whereSelectionableType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Selectionable whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Selectionable whereUserId($value)
     */
    class Selectionable extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Serie.
     *
     * @property int                                                                                                                           $id
     * @property null|string                                                                                                                   $title
     * @property null|string                                                                                                                   $slug_sort
     * @property null|string                                                                                                                   $slug
     * @property null|string                                                                                                                   $language_slug
     * @property \App\Enums\BookTypeEnum                                                                                                       $type
     * @property null|array                                                                                                                    $description
     * @property null|string                                                                                                                   $link
     * @property null|int                                                                                                                      $wikipedia_item_id
     * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
     * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
     * @property \App\Models\Author[]|\Illuminate\Database\Eloquent\Collection                                                                 $authors
     * @property null|int                                                                                                                      $authors_count
     * @property \App\Models\Book[]|\Illuminate\Database\Eloquent\Collection                                                                   $books
     * @property null|int                                                                                                                      $books_count
     * @property \App\Models\User[]|\Illuminate\Database\Eloquent\Collection                                                                   $favorites
     * @property null|int                                                                                                                      $favorites_count
     * @property \App\Models\Author                                                                                                            $author
     * @property string                                                                                                                        $authors_names
     * @property null|\App\Models\Media|\App\Models\MediaExtended                                                                              $cover_book
     * @property null|string                                                                                                                   $cover_color
     * @property null|string                                                                                                                   $cover_og
     * @property null|string                                                                                                                   $cover_original
     * @property null|string                                                                                                                   $cover_simple
     * @property null|string                                                                                                                   $cover_thumbnail
     * @property mixed                                                                                                                         $genres_list
     * @property bool                                                                                                                          $is_favorite
     * @property array                                                                                                                         $meta
     * @property null|string                                                                                                                   $meta_author
     * @property string                                                                                                                        $opds_link
     * @property mixed                                                                                                                         $reviews_link
     * @property mixed                                                                                                                         $tags_list
     * @property string                                                                                                                        $tags_string
     * @property null|\App\Models\Language                                                                                                     $language
     * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
     * @property null|int                                                                                                                      $media_count
     * @property \App\Models\Review[]|\Illuminate\Database\Eloquent\Collection                                                                 $reviews
     * @property null|int                                                                                                                      $reviews_count
     * @property \App\Models\User[]|\Illuminate\Database\Eloquent\Collection                                                                   $selections
     * @property null|int                                                                                                                      $selections_count
     * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[]                                                                   $tags
     * @property null|int                                                                                                                      $tags_count
     * @property null|\App\Models\WikipediaItem                                                                                                $wikipedia
     *
     * @method static \Database\Factories\SerieFactory            factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Serie newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Serie query()
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereAuthorIsLike(string $author)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereLanguageSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereLanguagesIs(...$languages)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereLink($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereSlugSort($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTagsAllIs(...$tags)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTagsIs(...$tags)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTypesIs(...$types)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie whereWikipediaItemId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie withAllTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie withAllTagsOfAnyType($tags)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie withAnyTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
     * @method static \Illuminate\Database\Eloquent\Builder|Serie withAnyTagsOfAnyType($tags)
     */
    class Serie extends \Eloquent implements \Spatie\MediaLibrary\HasMedia
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Submission.
     *
     * @property int                             $id
     * @property null|string                     $name
     * @property null|string                     $email
     * @property \App\Enums\SubmissionReasonEnum $reason
     * @property null|string                     $message
     * @property null|\Illuminate\Support\Carbon $created_at
     * @property null|\Illuminate\Support\Carbon $updated_at
     *
     * @method static \Database\Factories\SubmissionFactory            factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|Submission newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Submission newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Submission query()
     * @method static \Illuminate\Database\Eloquent\Builder|Submission whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Submission whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Submission whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Submission whereMessage($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Submission whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Submission whereReason($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Submission whereUpdatedAt($value)
     */
    class Submission extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\TagExtend.
     *
     * @property int                                                          $id
     * @property array                                                        $name
     * @property array                                                        $slug
     * @property null|\App\Enums\TagTypeEnum                                  $type
     * @property null|int                                                     $order_column
     * @property null|\Illuminate\Support\Carbon                              $created_at
     * @property null|\Illuminate\Support\Carbon                              $updated_at
     * @property \App\Models\Book[]|\Illuminate\Database\Eloquent\Collection  $books
     * @property null|int                                                     $books_count
     * @property string                                                       $books_link
     * @property mixed                                                        $first_char
     * @property string                                                       $show_link
     * @property \App\Models\Serie[]|\Illuminate\Database\Eloquent\Collection $series
     * @property null|int                                                     $series_count
     * @property \Illuminate\Database\Eloquent\Collection|TagExtend[]         $tags
     * @property null|int                                                     $tags_count
     *
     * @method static \Illuminate\Database\Eloquent\Builder|Tag       containing(string $name, $locale = null)
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Tag       ordered(string $direction = 'asc')
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend query()
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereIsNegligible(string $negligible)
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereNameEnIs(string $name)
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereOrderColumn($value)
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereTypeIs(string $type)
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend withAllTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend withAllTagsOfAnyType($tags)
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend withAnyTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
     * @method static \Illuminate\Database\Eloquent\Builder|TagExtend withAnyTagsOfAnyType($tags)
     * @method static \Illuminate\Database\Eloquent\Builder|Tag       withType(?string $type = null)
     */
    class TagExtend extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\User.
     *
     * @property int                                                                                                                           $id
     * @property string                                                                                                                        $name
     * @property string                                                                                                                        $username
     * @property string                                                                                                                        $email
     * @property null|\Illuminate\Support\Carbon                                                                                               $email_verified_at
     * @property string                                                                                                                        $password
     * @property bool                                                                                                                          $is_blocked
     * @property null|string                                                                                                                   $remember_token
     * @property null|string                                                                                                                   $about
     * @property \App\Enums\GenderEnum                                                                                                         $gender
     * @property \App\Enums\UserRole                                                                                                           $role
     * @property null|string                                                                                                                   $pronouns
     * @property int                                                                                                                           $use_gravatar
     * @property bool                                                                                                                          $display_favorites
     * @property bool                                                                                                                          $display_reviews
     * @property bool                                                                                                                          $display_gender
     * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
     * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
     * @property string                                                                                                                        $avatar
     * @property null|string                                                                                                                   $avatar_thumbnail
     * @property string                                                                                                                        $banner
     * @property null|string                                                                                                                   $color
     * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
     * @property null|int                                                                                                                      $media_count
     * @property \Illuminate\Notifications\DatabaseNotification[]|\Illuminate\Notifications\DatabaseNotificationCollection                     $notifications
     * @property null|int                                                                                                                      $notifications_count
     * @property \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[]                                               $tokens
     * @property null|int                                                                                                                      $tokens_count
     *
     * @method static \Database\Factories\UserFactory            factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|User query()
     * @method static \Illuminate\Database\Eloquent\Builder|User whereAbout($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereDisplayFavorites($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereDisplayGender($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereDisplayReviews($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereIsBlocked($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User wherePronouns($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereUseGravatar($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
     */
    class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia, \Filament\Models\Contracts\FilamentUser
    {
    }
}

namespace App\Models{
    /**
     * App\Models\WikipediaItem.
     *
     * @property int                             $id
     * @property null|string                     $model
     * @property null|string                     $language
     * @property string                          $search_query
     * @property null|string                     $query_url
     * @property null|string                     $page_id
     * @property null|string                     $page_id_url
     * @property null|string                     $page_url
     * @property null|string                     $extract
     * @property null|string                     $picture_url
     * @property null|\Illuminate\Support\Carbon $created_at
     * @property null|\Illuminate\Support\Carbon $updated_at
     * @property null|\App\Models\Author         $author
     * @property null|\App\Models\Serie          $serie
     *
     * @method static \Database\Factories\WikipediaItemFactory            factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem query()
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereExtract($value)
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereLanguage($value)
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereModel($value)
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem wherePageId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem wherePageIdUrl($value)
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem wherePageUrl($value)
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem wherePictureUrl($value)
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereQueryUrl($value)
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereSearchQuery($value)
     * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereUpdatedAt($value)
     */
    class WikipediaItem extends \Eloquent
    {
    }
}
