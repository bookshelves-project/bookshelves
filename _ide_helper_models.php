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
 * App\Models\Author
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $name
 * @property \App\Enums\AuthorRoleEnum|null $role
 * @property mixed|null $description
 * @property string|null $link
 * @property mixed|null $note
 * @property int|null $wikipedia_item_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $favorites
 * @property-read int|null $favorites_count
 * @property-read null|\App\Models\Media|\App\Models\MediaExtended $cover_book
 * @property-read string|null $cover_color
 * @property-read string|null $cover_og
 * @property-read string|null $cover_original
 * @property-read string|null $cover_simple
 * @property-read string|null $cover_thumbnail
 * @property-read mixed $genres_list
 * @property-read bool $is_favorite
 * @property-read mixed $reviews_link
 * @property-read mixed $tags_list
 * @property-read string $tags_string
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Serie[] $series
 * @property-read int|null $series_count
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\WikipediaItem|null $wikipedia
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
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereTagsAllIs(...$tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereTagsIs(...$tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereWikipediaItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author withAllTags(\ArrayAccess|\Spatie\Tags\Tag|array $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Author withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Author withAnyTags(\ArrayAccess|\Spatie\Tags\Tag|array $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Author withAnyTagsOfAnyType($tags)
 */
	class Author extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug_sort
 * @property string|null $slug
 * @property string|null $contributor
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $released_on
 * @property string|null $rights
 * @property int|null $serie_id
 * @property int|null $volume
 * @property int|null $publisher_id
 * @property string|null $language_slug
 * @property int|null $google_book_id
 * @property int|null $page_count
 * @property string|null $maturity_rating
 * @property bool $is_disabled
 * @property \App\Enums\BookTypeEnum $type
 * @property string|null $isbn10
 * @property string|null $isbn13
 * @property array|null $identifiers
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property-read int|null $authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $favorites
 * @property-read int|null $favorites_count
 * @property-read \App\Models\Author $author
 * @property-read string $authors_names
 * @property-read null|\App\Models\Media|\App\Models\MediaExtended $cover_book
 * @property-read string|null $cover_color
 * @property-read string|null $cover_og
 * @property-read string|null $cover_original
 * @property-read string|null $cover_simple
 * @property-read string|null $cover_thumbnail
 * @property-read mixed $genres_list
 * @property-read bool $is_favorite
 * @property-read string|null $isbn
 * @property-read string|null $meta_author
 * @property-read mixed $reviews_link
 * @property-read mixed $tags_list
 * @property-read string $tags_string
 * @property-read \App\Models\GoogleBook|null $googleBook
 * @property-read \App\Models\Language|null $language
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Publisher|null $publisher
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $selections
 * @property-read int|null $selections_count
 * @property-read \App\Models\Serie|null $serie
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\BookFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthorIsLike(string $author)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereContributor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDescription($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Book withAllTags(\ArrayAccess|\Spatie\Tags\Tag|array $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Book withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Book withAnyTags(\ArrayAccess|\Spatie\Tags\Tag|array $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Book withAnyTagsOfAnyType($tags)
 */
	class Book extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\CmsPage
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $language
 * @property \App\Enums\TemplateEnum $template
 * @property array|null $content
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read array $meta
 * @property-read array|null $page_transform
 * @property-read string|null $route_show
 * @property-read array $seo
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereUpdatedAt($value)
 */
	class CmsPage extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Favoritable
 *
 * @property int $user_id
 * @property int $favoritable_id
 * @property string $favoritable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $favoritable
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereFavoritableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereFavoritableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereUserId($value)
 */
	class Favoritable extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GoogleBook
 *
 * @property int $id
 * @property string|null $original_isbn
 * @property string|null $url
 * @property string|null $published_date
 * @property string|null $description
 * @property array|null $industry_identifiers
 * @property int|null $page_count
 * @property array|null $categories
 * @property string|null $maturity_rating
 * @property string|null $language
 * @property string|null $preview_link
 * @property string|null $publisher
 * @property int|null $retail_price_amount
 * @property int|null $retail_price_currency_code
 * @property string|null $buy_link
 * @property string|null $isbn10
 * @property string|null $isbn13
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Book|null $book
 * @method static \Database\Factories\GoogleBookFactory factory(...$parameters)
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
	class GoogleBook extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Language
 *
 * @property string $slug
 * @property array|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Serie[] $series
 * @property-read int|null $series_count
 * @method static \Database\Factories\LanguageFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereUpdatedAt($value)
 */
	class Language extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MediaExtended
 *
 * @property int $id
 * @property string $model_type
 * @property int $model_id
 * @property string|null $uuid
 * @property string $collection_name
 * @property string $name
 * @property string $file_name
 * @property string|null $mime_type
 * @property string $disk
 * @property string|null $conversions_disk
 * @property int $size
 * @property array $manipulations
 * @property array $custom_properties
 * @property array $generated_conversions
 * @property array $responsive_images
 * @property int|null $order_column
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string|null $download
 * @property-read string|null $full_extension
 * @property-read string|null $size_human
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|static[] all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended query()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereCollectionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereConversionsDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereCustomProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereGeneratedConversions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereManipulations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereResponsiveImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaExtended whereUuid($value)
 */
	class MediaExtended extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property \App\Enums\PublishStatusEnum $status
 * @property string|null $summary
 * @property string|null $body
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read array $seo
 * @method static \Database\Factories\PageFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page published()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property int $id
 * @property int|null $category_id
 * @property string $title
 * @property \App\Enums\PublishStatusEnum $status
 * @property string|null $summary
 * @property string|null $body
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $is_pineed
 * @property string $slug
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PostCategory|null $category
 * @property-read array $seo
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\PostFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post published()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsPineed($value)
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
	class Post extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\PostCategory
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Database\Factories\PostCategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereUpdatedAt($value)
 */
	class PostCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Publisher
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @method static \Database\Factories\PublisherFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher query()
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereUpdatedAt($value)
 */
	class Publisher extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Review
 *
 * @property int $id
 * @property string|null $text
 * @property int|null $rating
 * @property int|null $user_id
 * @property int|null $reviewable_id
 * @property string|null $reviewable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property-read int|null $authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $reviewable
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Serie[] $series
 * @property-read int|null $series_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ReviewFactory factory(...$parameters)
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
	class Review extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Selectionable
 *
 * @property int $id
 * @property int $user_id
 * @property int $selectionable_id
 * @property string $selectionable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\SelectionableFactory factory(...$parameters)
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
	class Selectionable extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Serie
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug_sort
 * @property string|null $slug
 * @property string|null $language_slug
 * @property \App\Enums\BookTypeEnum $type
 * @property array|null $description
 * @property string|null $link
 * @property int|null $wikipedia_item_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property-read int|null $authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $favorites
 * @property-read int|null $favorites_count
 * @property-read \App\Models\Author $author
 * @property-read string $authors_names
 * @property-read null|\App\Models\Media|\App\Models\MediaExtended $cover_book
 * @property-read string|null $cover_color
 * @property-read string|null $cover_og
 * @property-read string|null $cover_original
 * @property-read string|null $cover_simple
 * @property-read string|null $cover_thumbnail
 * @property-read mixed $genres_list
 * @property-read bool $is_favorite
 * @property-read string|null $meta_author
 * @property-read mixed $reviews_link
 * @property-read mixed $tags_list
 * @property-read string $tags_string
 * @property-read \App\Models\Language|null $language
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $selections
 * @property-read int|null $selections_count
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\WikipediaItem|null $wikipedia
 * @method static \Database\Factories\SerieFactory factory(...$parameters)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Serie withAllTags(\ArrayAccess|\Spatie\Tags\Tag|array $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie withAnyTags(\ArrayAccess|\Spatie\Tags\Tag|array $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie withAnyTagsOfAnyType($tags)
 */
	class Serie extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Submission
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property \App\Enums\SubmissionReasonEnum $reason
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\SubmissionFactory factory(...$parameters)
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
	class Submission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TagExtend
 *
 * @property int $id
 * @property array $name
 * @property array $slug
 * @property \App\Enums\TagTypeEnum|null $type
 * @property int|null $order_column
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @property-read string $books_link
 * @property-read mixed $first_char
 * @property-read string $show_link
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Serie[] $series
 * @property-read int|null $series_count
 * @property \Illuminate\Database\Eloquent\Collection|TagExtend[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tag containing(string $name, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag ordered(string $direction = 'asc')
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
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend withAllTags(\ArrayAccess|\Spatie\Tags\Tag|array $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend withAnyTags(\ArrayAccess|\Spatie\Tags\Tag|array $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag withType(?string $type = null)
 */
	class TagExtend extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property bool $is_blocked
 * @property string|null $remember_token
 * @property string|null $about
 * @property \App\Enums\GenderEnum $gender
 * @property \App\Enums\UserRole $role
 * @property string|null $pronouns
 * @property int $use_gravatar
 * @property bool $display_favorites
 * @property bool $display_reviews
 * @property bool $display_gender
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $avatar
 * @property-read string|null $avatar_thumbnail
 * @property-read string $banner
 * @property-read string|null $color
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
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
	class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia, \Filament\Models\Contracts\FilamentUser {}
}

namespace App\Models{
/**
 * App\Models\WikipediaItem
 *
 * @property int $id
 * @property string|null $model
 * @property string|null $language
 * @property string $search_query
 * @property string|null $query_url
 * @property string|null $page_id
 * @property string|null $page_id_url
 * @property string|null $page_url
 * @property string|null $extract
 * @property string|null $picture_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Author|null $author
 * @property-read \App\Models\Serie|null $serie
 * @method static \Database\Factories\WikipediaItemFactory factory(...$parameters)
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
	class WikipediaItem extends \Eloquent {}
}

