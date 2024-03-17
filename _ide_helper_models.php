<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $author_main
 * @property array|null $authors
 * @property array|null $narrators
 * @property string|null $description
 * @property string|null $publisher
 * @property \Illuminate\Support\Carbon|null $publish_date
 * @property string|null $language
 * @property array|null $tags
 * @property string|null $serie
 * @property int|null $volume
 * @property string|null $format
 * @property string|null $track_number
 * @property string|null $comment
 * @property string|null $creation_date
 * @property string|null $composer
 * @property string|null $disc_number
 * @property bool|null $is_compilation
 * @property string|null $encoding
 * @property string|null $lyrics
 * @property string|null $stik
 * @property float|null $duration
 * @property string|null $physical_path
 * @property string|null $basename
 * @property string|null $extension
 * @property string|null $mime_type
 * @property int|null $size
 * @property \Illuminate\Support\Carbon|null $added_at
 * @property string|null $book_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Book|null $book
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook query()
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereAddedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereAuthorMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereAuthors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereBasename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereComposer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereCreationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereDiscNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereEncoding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereIsCompilation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereLyrics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereNarrators($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook wherePhysicalPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook wherePublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereSerie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereStik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereTrackNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audiobook whereVolume($value)
 */
	class Audiobook extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $slug
 * @property string $name
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $role
 * @property string|null $description
 * @property string|null $link
 * @property \Illuminate\Support\Carbon|null $wikipedia_parsed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @property-read string|null $cover
 * @property-read string|null $cover_color
 * @property-read null|\App\Models\Media|\App\Models\MediaExtended $cover_media
 * @property-read string|null $cover_opds
 * @property-read string|null $cover_social
 * @property-read string|null $cover_standard
 * @property-read string|null $cover_thumbnail
 * @property-read string $entity
 * @property-read \Kiwilan\Steward\Utils\DownloadFile|null $file_main
 * @property-read array $files_list
 * @property-read mixed $first_char
 * @property-read \App\Models\Collection<int, Tag> $genres_list
 * @property-read string $meta_class
 * @property-read string $meta_class_name
 * @property-read string $meta_class_name_plural
 * @property-read string $meta_class_namespaced
 * @property-read string $meta_class_slug
 * @property-read string $meta_class_slug_plural
 * @property-read string $meta_class_snake
 * @property-read string $meta_class_snake_plural
 * @property-read string $meta_first_char
 * @property-read string|null $meta_route
 * @property-read string $opds_link
 * @property-read \App\Models\Collection<int, Tag> $tags_list
 * @property-read string $tags_string
 * @property-read string $title
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Serie> $series
 * @property-read int|null $series_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author query()
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereFirstChar(string $char)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereHasBooks()
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereTagsAllIs(iterable ...$tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereTagsIs(iterable ...$tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereWikipediaParsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author withAllTags(\Illuminate\Support\Collection $tags)
 */
	class Author extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string|null $contributor
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $released_on
 * @property array|null $audiobook_narrators
 * @property array|null $audiobook_chapters
 * @property string|null $rights
 * @property string|null $serie_id
 * @property string|null $author_main_id
 * @property int|null $volume
 * @property string|null $publisher_id
 * @property string|null $language_slug
 * @property int|null $page_count
 * @property bool $is_maturity_rating
 * @property bool $is_hidden
 * @property \App\Enums\BookTypeEnum|null $type
 * @property \App\Enums\BookFormatEnum|null $format
 * @property string|null $isbn10
 * @property string|null $isbn13
 * @property array|null $identifiers
 * @property \Illuminate\Support\Carbon|null $google_book_parsed_at
 * @property string|null $physical_path
 * @property string|null $extension
 * @property string|null $mime_type
 * @property int|null $size
 * @property \Illuminate\Support\Carbon|null $added_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audiobook> $audiobooks
 * @property-read int|null $audiobooks_count
 * @property-read \App\Models\Author|null $authorMain
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Author> $authors
 * @property-read int|null $authors_count
 * @property-read string $authors_names
 * @property-read string|null $cover
 * @property-read string|null $cover_color
 * @property-read null|\App\Models\Media|\App\Models\MediaExtended $cover_media
 * @property-read string|null $cover_opds
 * @property-read string|null $cover_social
 * @property-read string|null $cover_standard
 * @property-read string|null $cover_thumbnail
 * @property-read string $download_link
 * @property-read string $entity
 * @property-read \Kiwilan\Steward\Utils\DownloadFile|null $file_main
 * @property-read \App\Models\Collection<int, ?MediaExtended> $files
 * @property-read \App\Models\Collection<string, DownloadFile> $files_list
 * @property-read \App\Models\Collection<int, Tag> $genres_list
 * @property-read string|null $isbn
 * @property-read string|null $meta_author
 * @property-read string $meta_class
 * @property-read string $meta_class_name
 * @property-read string $meta_class_name_plural
 * @property-read string $meta_class_namespaced
 * @property-read string $meta_class_slug
 * @property-read string $meta_class_slug_plural
 * @property-read string $meta_class_snake
 * @property-read string $meta_class_snake_plural
 * @property-read string $meta_first_char
 * @property-read string|null $meta_route
 * @property-read string $opds_link
 * @property-read string|null $size_human
 * @property-read \App\Models\Collection<int, Tag> $tags_list
 * @property-read string $tags_string
 * @property-read string|null $volume_pad
 * @property-read \App\Models\Language|null $language
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Publisher|null $publisher
 * @property-read \App\Models\Serie|null $serie
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Book available()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book publishedBetween(string $startDate, string $endDate)
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAddedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAudiobookChapters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAudiobookNarrators($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthorIsLike(string $author)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthorMainId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereContributor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDisallowSerie(string $has_not_serie)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereGoogleBookParsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIdentifiers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsAudiobook()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsBook()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsComic()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsManga()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsMaturityRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsbn10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsbn13($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereLanguageSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereLanguagesIs(...$languages)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePageCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePhysicalPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePublisherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereReleasedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereRights($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSerieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTagsAllIs(iterable ...$tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTagsIs(iterable ...$tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTypesIs(...$types)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereVolume($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book withAllTags(\Illuminate\Support\Collection $tags)
 */
	class Book extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $ip
 * @property string|null $user_agent
 * @property string|null $name
 * @property string|null $type
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Download newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Download newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Download query()
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereUserId($value)
 */
	class Download extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $slug
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Serie> $series
 * @property-read int|null $series_count
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
 * 
 *
 * @property int $id
 * @property string $model_type
 * @property int $model_id
 * @property string|null $uuid
 * @property string $collection_name
 * @property-read string $name
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
 * @property-read mixed $extension
 * @property-read string|null $download
 * @property-read string|null $full_extension
 * @property-read string|null $size_human
 * @property-read mixed $human_readable_size
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @property-read mixed $original_url
 * @property-read mixed $preview_url
 * @property-read mixed $type
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
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
 * 
 *
 * @property string $id
 * @property string|null $slug
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @property-read mixed $books_route
 * @property-read array $meta
 * @property-read string|null $show_route
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
 * 
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string|null $language_slug
 * @property \App\Enums\BookTypeEnum $type
 * @property string|null $description
 * @property string|null $link
 * @property string|null $author_main_id
 * @property \Illuminate\Support\Carbon|null $wikipedia_parsed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Author|null $authorMain
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Author> $authors
 * @property-read int|null $authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @property-read string $authors_names
 * @property-read string $books_link
 * @property-read string|null $cover
 * @property-read string|null $cover_color
 * @property-read null|\App\Models\Media|\App\Models\MediaExtended $cover_media
 * @property-read string|null $cover_opds
 * @property-read string|null $cover_social
 * @property-read string|null $cover_standard
 * @property-read string|null $cover_thumbnail
 * @property-read string $download_link
 * @property-read string $entity
 * @property-read \Kiwilan\Steward\Utils\DownloadFile|null $file_main
 * @property-read array $files_list
 * @property-read mixed $first_char
 * @property-read \App\Models\Collection<int, Tag> $genres_list
 * @property-read string|null $meta_author
 * @property-read string $meta_class
 * @property-read string $meta_class_name
 * @property-read string $meta_class_name_plural
 * @property-read string $meta_class_namespaced
 * @property-read string $meta_class_slug
 * @property-read string $meta_class_slug_plural
 * @property-read string $meta_class_snake
 * @property-read string $meta_class_snake_plural
 * @property-read string $meta_first_char
 * @property-read string|null $meta_route
 * @property-read string $opds_link
 * @property-read \App\Models\Collection<int, Tag> $tags_list
 * @property-read string $tags_string
 * @property-read \App\Models\Language|null $language
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Serie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereAuthorIsLike(string $author)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereAuthorMainId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereFirstChar(string $char)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereHasBooks()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereIsAudiobook()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereIsBook()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereIsComic()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereIsManga()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereLanguageSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereLanguagesIs(...$languages)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTagsAllIs(iterable ...$tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTagsIs(iterable ...$tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTypesIs(...$types)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereWikipediaParsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie withAllTags(\Illuminate\Support\Collection $tags)
 */
	class Serie extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property \App\Enums\TagTypeEnum $type
 * @property int|null $order_column
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Serie> $series
 * @property-read int|null $series_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereIsNegligible(string $negligible)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Kiwilan\Steward\Enums\UserRoleEnum $role
 * @property bool $is_blocked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read bool $is_admin
 * @property-read bool $is_editor
 * @property-read bool $is_super_admin
 * @property-read bool $is_user
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User haveDashboardAccess()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsBlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsNotSuperAdmin()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsUser()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

