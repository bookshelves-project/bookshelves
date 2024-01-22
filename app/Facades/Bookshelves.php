<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string appVersion()
 * @method static string analyzerEngine()
 * @method static string analyzerDebug()
 * @method static bool authorWikipediaExact()
 * @method static array{books: string|false, comics: string|false, mangas: string|false, audiobooks: string|false} library()
 * @method static bool convertCovers()
 */
class Bookshelves extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bookshelves';
    }
}
