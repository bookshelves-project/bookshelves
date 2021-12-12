<?php

namespace App\Models;

use App\Services\ConverterEngine\TagConverter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * App\Models\GoogleBook.
 *
 * @property int                             $id
 * @property null|string                     $date
 * @property null|string                     $description
 * @property null|mixed                      $industry_identifiers
 * @property null|int                        $page_count
 * @property null|mixed                      $categories
 * @property null|string                     $maturity_rating
 * @property null|string                     $language
 * @property null|string                     $preview_link
 * @property null|string                     $publisher
 * @property null|int                        $retail_price_amount
 * @property null|int                        $retail_price_currency_code
 * @property null|string                     $buy_link
 * @property null|string                     $isbn
 * @property null|string                     $isbn13
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property null|\App\Models\Book           $book
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook query()
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereBuyLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereIndustryIdentifiers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereIsbn13($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereMaturityRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook wherePageCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook wherePreviewLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook wherePublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereRetailPriceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereRetailPriceCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GoogleBook extends Model
{
    protected $fillable = [
        'date',
        'description',
        'industry_identifiers',
        'page_count',
        'categories',
        'maturity_rating',
        'language',
        'preview_link',
        'publisher',
        'retail_price_amount',
        'retail_price_currency_code',
        'buy_link',
        'isbn',
        'isbn13',
    ];

    /**
     * Add more data to Book from GoogleBook.
     */
    public function improveBookData()
    {
        $this->testAttribute('date');
        $this->testAttribute('description');
        $this->testAttribute('page_count');
        $this->testAttribute('maturity_rating');

        if (! $this->book->publisher && $this->publisher) {
            $publisher_slug = Str::slug($this->publisher, '-');
            $publisher = Publisher::whereSlug($publisher_slug)->first();
            if (! $publisher) {
                $publisher = Publisher::firstOrCreate([
                    'name' => $this->publisher,
                    'slug' => $publisher_slug,
                ]);
            }
            $this->book->publisher()->associate($publisher);
        }
        $this->book->save();

        $identifier = $this->book->identifier;
        if ($identifier) {
            if (empty($identifier->isbn)) {
                $identifier->isbn = $this->isbn;
            }
            if (empty($identifier->isbn13)) {
                $identifier->isbn13 = $this->isbn13;
            }
            $identifier->save();
        }

        $categories = json_decode($this->categories);
        if (is_array($categories)) {
            foreach ($categories as $key => $category) {
                TagConverter::tagRaw($category, $this->book);
            }
        }
    }

    public function testAttribute($attribute)
    {
        if (empty($this->book->attribute)) {
            $this->book->{$attribute} = $this->{$attribute};
        }
    }

    public function book(): HasOne
    {
        return $this->hasOne(Book::class);
    }
}
