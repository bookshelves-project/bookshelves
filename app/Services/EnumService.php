<?php

namespace App\Services;

use App\Enums\AuthorRoleEnum;
use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
use App\Enums\ChartColorEnum;
use App\Enums\CountSizeEnum;
use App\Enums\EntityEnum;
use App\Enums\GenderEnum;
use App\Enums\PostStatusEnum;
use App\Enums\RoleEnum;
use App\Enums\TagTypeEnum;

class EnumService
{
    public static function list(): array
    {
        $author_roles = AuthorRoleEnum::toArray();
        $book_formats = BookFormatEnum::toArray();
        $book_types = BookTypeEnum::toArray();
        $count_sizes = CountSizeEnum::toArray();
        $entities = EntityEnum::toArray();
        $genders = GenderEnum::toArray();
        $post_status = PostStatusEnum::toArray();
        $roles = RoleEnum::toArray();
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
            'countSizes' => $count_sizes,
            'entities' => $entities,
            'genders' => $genders,
            'postStatus' => $post_status,
            'roles' => $roles,
            'tagTypes' => $tag_types,
            'models' => $models,
        ];
    }
}
