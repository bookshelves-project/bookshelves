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
 * @method static string imageDisk()
 * @method static string imageCollection()
 * @method static string imageDriver()
 * @method static string imageFormat()
 * @method static int imageMaxHeight()
 * @method static bool imageConversion()
 * @method static array{width: int, height: int} imageCoverStandard()
 * @method static array{width: int, height: int} imageCoverThumbnail()
 * @method static array{width: int, height: int} imageCoverSocial()
 * @method static ?string notificationDiscordWebhook()
 */
class Bookshelves extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bookshelves';
    }
}
