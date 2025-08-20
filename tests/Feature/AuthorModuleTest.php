<?php

use App\Engines\Converter\Modules\AuthorModule;
use Kiwilan\Ebook\Ebook;

test('can parse author name', function () {
    $ebook = Ebook::read(EPUB);
    $authors = AuthorModule::make($ebook->getAuthors());

    $first = $authors->first()->name;
    expect($first)->toBe('Jean M. Auel');
});
