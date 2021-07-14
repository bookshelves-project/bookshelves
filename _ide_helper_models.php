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
 * @property string|null $role
 * @property string|null $description
 * @property string|null $link
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $favorites
 * @property-read int|null $favorites_count
 * @property-read string $download_link
 * @property-read string|null $image_color
 * @property-read string|null $image_open_graph
 * @property-read string|null $image_simple
 * @property-read string|null $image_thumbnail
 * @property-read bool $is_favorite
 * @property-read string $show_books_link
 * @property-read string $show_link
 * @property-read string $show_link_opds
 * @property-read string $show_series_link
 * @property-read string $size
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Serie[] $series
 * @property-read int|null $series_count
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[] $tags
 * @property-read int|null $tags_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|Author withAllTags(\ArrayAccess|\Spatie\Tags\Tag|array $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Author withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Author withAnyTags(\ArrayAccess|\Spatie\Tags\Tag|array $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Author withAnyTagsOfAnyType($tags)
 */
    class Author extends \Eloquent implements \Spatie\MediaLibrary\HasMedia
    {
    }
}

namespace App\Models{
/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $title
 * @property string|null $title_sort
 * @property string|null $slug
 * @property string|null $contributor
 * @property string|null $description
 * @property string|null $date
 * @property string|null $rights
 * @property int|null $serie_id
 * @property int|null $volume
 * @property int|null $publisher_id
 * @property string|null $language_slug
 * @property int|null $identifier_id
 * @property int|null $google_book_id
 * @property int|null $page_count
 * @property string|null $maturity_rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property-read int|null $authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $favorites
 * @property-read int|null $favorites_count
 * @property-read string $download_link
 * @property-read string|null $epub
 * @property-read mixed $genres_list
 * @property-read string|null $image_color
 * @property-read string|null $image_open_graph
 * @property-read string|null $image_original
 * @property-read string|null $image_simple
 * @property-read string|null $image_thumbnail
 * @property-read bool $is_favorite
 * @property-read string|null $meta_author
 * @property-read string $show_link
 * @property-read string $sort_name
 * @property-read mixed $tags_list
 * @property-read \App\Models\GoogleBook|null $googleBook
 * @property-read \App\Models\Identifier|null $identifier
 * @property-read \App\Models\Language|null $language
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Publisher|null $publisher
 * @property-read \App\Models\Serie|null $serie
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\BookFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereContributor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereGoogleBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIdentifierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereLanguageSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereMaturityRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePageCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePublisherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereRights($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSerieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitleSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereVolume($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book withAllTags(\ArrayAccess|\Spatie\Tags\Tag|array $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Book withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Book withAnyTags(\ArrayAccess|\Spatie\Tags\Tag|array $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Book withAnyTagsOfAnyType($tags)
 */
    class Book extends \Eloquent implements \Spatie\MediaLibrary\HasMedia
    {
    }
}

namespace App\Models{
/**
 * App\Models\Comment
 *
 * @property int $id
 * @property string|null $text
 * @property int|null $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $commentable_id
 * @property string|null $commentable_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property-read int|null $authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Serie[] $series
 * @property-read int|null $series_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\CommentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 */
    class Comment extends \Eloquent
    {
    }
}

namespace App\Models{
/**
 * App\Models\Favoritable
 *
 * @property int $user_id
 * @property int $favoritable_id
 * @property string $favoritable_type
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $favoritable
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereFavoritableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereFavoritableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereUserId($value)
 */
    class Favoritable extends \Eloquent
    {
    }
}

namespace App\Models{
/**
 * App\Models\GoogleBook
 *
 * @property int $id
 * @property string|null $preview_link
 * @property string|null $buy_link
 * @property int|null $retail_price
 * @property string|null $retail_price_currency
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Book|null $book
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook query()
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereBuyLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook wherePreviewLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereRetailPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereRetailPriceCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereUpdatedAt($value)
 */
    class GoogleBook extends \Eloquent
    {
    }
}

namespace App\Models{
/**
 * App\Models\Identifier
 *
 * @property int $id
 * @property string|null $isbn
 * @property string|null $isbn13
 * @property string|null $doi
 * @property string|null $amazon
 * @property string|null $google
 * @property-read \App\Models\Book|null $book
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier query()
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier whereAmazon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier whereDoi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier whereGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier whereIsbn13($value)
 */
    class Identifier extends \Eloquent
    {
    }
}

namespace App\Models{
/**
 * App\Models\Language
 *
 * @property string|null $slug
 * @property string|null $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Serie[] $series
 * @property-read int|null $series_count
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereSlug($value)
 */
    class Language extends \Eloquent
    {
    }
}

namespace App\Models{
/**
 * App\Models\Publisher
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @property-read string $show_link
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher query()
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereSlug($value)
 */
    class Publisher extends \Eloquent
    {
    }
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property \App\Enums\RoleEnum $name
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 */
    class Role extends \Eloquent
    {
    }
}

namespace App\Models{
/**
 * App\Models\Serie
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $title_sort
 * @property string|null $slug
 * @property string|null $language_slug
 * @property string|null $description
 * @property string|null $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property-read int|null $authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $favorites
 * @property-read int|null $favorites_count
 * @property-read string $download_link
 * @property-read mixed $genres_list
 * @property-read string|null $image_color
 * @property-read string|null $image_open_graph
 * @property-read string|null $image_original
 * @property-read string|null $image_simple
 * @property-read string|null $image_thumbnail
 * @property-read bool $is_favorite
 * @property-read string|null $meta_author
 * @property-read string $show_books_link
 * @property-read string $show_link
 * @property-read string $size
 * @property-read mixed $tags_list
 * @property-read \App\Models\Language|null $language
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\SerieFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereLanguageSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTitleSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie withAllTags(\ArrayAccess|\Spatie\Tags\Tag|array $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie withAnyTags(\ArrayAccess|\Spatie\Tags\Tag|array $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie withAnyTagsOfAnyType($tags)
 */
    class Serie extends \Eloquent implements \Spatie\MediaLibrary\HasMedia
    {
    }
}

namespace App\Models{
/**
 * App\Models\Submission
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Submission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Submission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Submission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereUpdatedAt($value)
 */
    class Submission extends \Eloquent
    {
    }
}

namespace App\Models{
/**
 * App\Models\TagExtend
 *
 * @property int $id
 * @property array $name
 * @property array $slug
 * @property string|null $type
 * @property int|null $order_column
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Tag containing(string $name, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag ordered(string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend query()
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagExtend whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag withType(?string $type = null)
 */
    class TagExtend extends \Eloquent
    {
    }
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property bool $gravatar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read string $avatar
 * @property-read string $profile_photo_url
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGravatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
    class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia
    {
    }
}
