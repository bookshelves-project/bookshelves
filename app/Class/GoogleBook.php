<?php

namespace App\Class;

use DateTime;

/**
 * GoogleBook item.
 *
 * @property string   $original_isbn
 * @property string   $url
 * @property string   $model_name
 * @property int      $model_id
 * @property DateTime $published_date
 * @property string   $description
 * @property array    $industry_identifiers
 * @property int      $page_count
 * @property array    $categories
 * @property string   $maturity_rating
 * @property string   $language
 * @property string   $preview_link
 * @property string   $publisher
 * @property int      $retail_price_amount
 * @property int      $retail_price_currency_code
 * @property string   $buy_link
 * @property string   $isbn10
 * @property string   $isbn13
 * @property bool     $debug
 */
class GoogleBook
{
    public function __construct(
        public int $model_id,
        public string $model_name,
        public ?string $original_isbn = null,
        public ?string $url = null,
        public ?DateTime $published_date = null,
        public ?string $description = null,
        public array $industry_identifiers = [],
        public ?int $page_count = null,
        public array $categories = [],
        public ?string $maturity_rating = null,
        public ?string $language = null,
        public ?string $preview_link = null,
        public ?string $publisher = null,
        public ?int $retail_price_amount = null,
        public ?int $retail_price_currency_code = null,
        public ?string $buy_link = null,
        public ?string $isbn10 = null,
        public ?string $isbn13 = null,
    ) {
    }
}
