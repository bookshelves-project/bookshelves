<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string appVersion()
 * @method static array{books: string|false, comics: string|false, mangas: string|false, audiobooks: string|false} library()
 */
class Bookshelves extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bookshelves';
    }
}
