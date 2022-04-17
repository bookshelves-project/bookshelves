<?php

namespace App\Models;

use App\Engines\ConverterEngine\BookConverter;
use App\Engines\ConverterEngine\TagConverter;
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
        'isbn10',
        'isbn13',
    ];

    /**
     * Add more data to Book from GoogleBook.
     */
    public function improveBook()
    {
        $this->testAttribute('released_on');
        BookConverter::setDescription($this->book, $this->language, $this->description);
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

        if (empty($this->book->isbn10)) {
            $this->book->isbn10 = $this->isbn10;
        }
        if (empty($this->book->isbn13)) {
            $this->book->isbn13 = $this->isbn13;
        }

        $categories = json_decode($this->categories);
        if (is_array($categories)) {
            foreach ($categories as $key => $category) {
                TagConverter::setTag($category);
            }
        }
        $this->book->save();
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
