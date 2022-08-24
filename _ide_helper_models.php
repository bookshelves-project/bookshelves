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
 * App\Models\Content
 *
 * @property-read array $meta
 * @property-read string|null $route_show
 * @method static \Illuminate\Database\Eloquent\Builder|Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Content query()
 */
	class Content extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property-read array $meta
 * @property-read string|null $route_show
 * @property-read array $seo
 * @property-read string $show_live
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property \App\Enums\PostTypeEnum $type
 * @property \App\Enums\PublishStatusEnum $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TeamMember[] $authors
 * @property-read int|null $authors_count
 * @property-read array $meta
 * @property-read mixed $recent
 * @property-read mixed $related
 * @property-read string|null $route_show
 * @property-read array $seo
 * @property-read string $show_live
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post published()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Reference
 *
 * @property \App\Enums\PublishStatusEnum $status
 * @property-read \App\Models\ReferenceCategory|null $category
 * @property-read array $meta
 * @property-read string|null $route_show
 * @property-read array $seo
 * @property-read string $show_live
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder|Reference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reference published()
 * @method static \Illuminate\Database\Eloquent\Builder|Reference query()
 */
	class Reference extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReferenceCategory
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reference[] $references
 * @property-read int|null $references_count
 * @method static \Illuminate\Database\Eloquent\Builder|ReferenceCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferenceCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferenceCategory query()
 */
	class ReferenceCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Service
 *
 * @property \App\Enums\ColorEnum $color
 * @property-read array $meta
 * @property-read string|null $route_show
 * @property-read array $seo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reference[] $references
 * @property-read int|null $references_count
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 */
	class Service extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Submission
 *
 * @property \App\Enums\ContactSubjectEnum $subject
 * @property-read mixed $cv_file
 * @property-read mixed $lm_file
 * @method static \Illuminate\Database\Eloquent\Builder|Submission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Submission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Submission query()
 */
	class Submission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tag
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TeamMember
 *
 * @property-read mixed $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember query()
 */
	class TeamMember extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property bool $is_blocked
 * @property \App\Enums\UserRole $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsBlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

