<?php

namespace App\Models;

use App\Services\ConverterEngine\TagConverter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class GoogleBook extends Model
{
    protected $fillable = [
        'url',
        'original_isbn',
        'published_date',
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
        $this->testAttribute('released_on');
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

        if (empty($this->book->identifier_isbn)) {
            $this->book->identifier_isbn = $this->isbn;
        }
        if (empty($this->book->identifier_isbn13)) {
            $this->book->identifier_isbn13 = $this->isbn13;
        }
        $this->book->save();

        $categories = json_decode($this->categories);
        if (is_array($categories)) {
            foreach ($categories as $key => $category) {
                TagConverter::tagRaw($category, $this->book);
            }
        }
    }

    public function testAttribute($attribute)
    {
        if (empty($this->book->{$attribute}) && $this->{$attribute}) {
            $this->book->{$attribute} = $this->{$attribute};
        }
    }

    public function book(): HasOne
    {
        return $this->hasOne(Book::class);
    }
}
