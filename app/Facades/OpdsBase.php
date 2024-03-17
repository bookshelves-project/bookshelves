<?php

namespace App\Facades;

use App\Models\Book;
use Closure;
use Illuminate\Support\Facades\Facade;
use Kiwilan\Opds\Entries\OpdsEntryBook;
use Kiwilan\Opds\Entries\OpdsEntryNavigation;
use Kiwilan\Opds\Opds;
use Kiwilan\Opds\OpdsConfig;

/**
 * @method static Opds app()
 * @method static OpdsConfig config()
 * @method static array<OpdsEntryNavigation> home()
 * @method static mixed cache(string $name, Closure $closure)
 * @method static OpdsEntryBook bookToEntry(Book $book)
 */
class OpdsBase extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Utils\OpdsBase::class;
    }
}
