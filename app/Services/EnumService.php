<?php

namespace App\Services;

use App\Enums\AuthorRoleEnum;
use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
use App\Enums\EntityEnum;
use App\Enums\GenderEnum;
use App\Enums\PublishStatusEnum;
use App\Enums\SubmissionReasonEnum;
use App\Enums\TagTypeEnum;
use App\Enums\UserRole;

class EnumService
{
    public static function list(): array
    {
        $author_roles = AuthorRoleEnum::toArray();
        $book_formats = BookFormatEnum::toArray();
        $book_types = BookTypeEnum::toArray();
        $entities = EntityEnum::toArray();
        $genders = GenderEnum::toArray();
        $post_status = PublishStatusEnum::toArray();
        $roles = UserRole::toArray();
        $submissions_reasons = SubmissionReasonEnum::toArray();
        $tag_types = TagTypeEnum::toArray();

        $models = [
            'author' => 'Author',
            'book' => 'Book',
            'language' => 'Language',
            'publisher' => 'Publisher',
            'serie' => 'Serie',
            'tagextended' => 'TagExtended',
        ];

        return [
            'authorRoles' => $author_roles,
            'bookFormats' => $book_formats,
            'bookTypes' => $book_types,
            'entities' => $entities,
            'genders' => $genders,
            'postStatus' => $post_status,
            'roles' => $roles,
            'submissionsReasons' => $submissions_reasons,
            'tagTypes' => $tag_types,
            'models' => $models,
        ];
    }
}
