<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string appVersion()
 */
class Bookshelves extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bookshelves';
    }
}
