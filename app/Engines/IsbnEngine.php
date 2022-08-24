<?php

namespace App\Engines;

class IsbnEngine
{
    public const options = [
        'http://classify.oclc.org/classify2/Classify?isbn=978-2-266-26628-4&summary=true' => 'https://www.worldcat.org',
        'http://openlibrary.org/api/volumes/brief/isbn/0596156715.json' => 'https://openlibrary.org',
        'https://www.googleapis.com/books/v1/volumes?q=isbn:9782266266284' => 'https://developers.google.com/books/docs/v1/using',
    ];
}
