<?php

namespace App\Models;

use App\Services\ConverterEngine\TagConverter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

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
    public function improveBookData(Book $book)
    {
        $this->book()->save($book);

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

        $identifier = Identifier::find($this->book->identifier->id);
        if (empty($identifier->isbn)) {
            $identifier->isbn = $this->isbn;
        }
        if (empty($identifier->isbn13)) {
            $identifier->isbn13 = $this->isbn13;
        }
        $identifier->save();

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
