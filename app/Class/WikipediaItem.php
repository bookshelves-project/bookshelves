<?php

namespace App\Class;

/**
 * Class to store WikipediaItem data.
 *
 * @property int     $model_id     Model ID
 * @property string  $model_name   Model class name, `Author::class`.
 * @property ?string $language     Wikipedia instance language
 * @property ?string $search_query Wikipedia search query
 * @property ?string $query_url    Wikipedia query url
 * @property ?string $page_id      Wikipedia page id
 * @property ?string $page_id_url  Wikipedia page id url
 * @property ?string $page_url     Wikipedia page url
 * @property ?string $extract      Wikipedia extract
 * @property ?string $picture_url  Wikipedia picture url
 */
class WikipediaItem
{
    public function __construct(
        public int $model_id,
        public string $model_name,
        public ?string $language = null,
        public ?string $search_query = null,
        public ?string $query_url = null,
        public ?string $page_id = null,
        public ?string $page_id_url = null,
        public ?string $page_url = null,
        public ?string $extract = null,
        public ?string $picture_url = null,
    ) {
    }
}
