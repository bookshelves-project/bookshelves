<?php

use App\Engines\Book\Converter\Modules\AuthorModule;
use Kiwilan\Ebook\Ebook;

test('can parse author name', function () {
    $ebook = Ebook::read(EPUB);
    $authors = AuthorModule::toCollection($ebook);

    $first = $authors->first()->name;
    expect($first)->toBe('Jean M. Auel');
});
