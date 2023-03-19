<?php

namespace App\Engines\Book;

use App\Engines\Book\Parser\Models\BookEntity;
use App\Engines\Book\Parser\Models\BookEntityFile;
use App\Engines\Book\Parser\Modules\CbaModule;
use App\Engines\Book\Parser\Modules\EpubModule;
use App\Engines\Book\Parser\Modules\NameModule;
use App\Engines\Book\Parser\Modules\PdfModule;
use App\Engines\Book\Parser\Utils\BookFileReader;
use App\Enums\BookFormatEnum;
use Illuminate\Support\Facades\Storage;
use Kiwilan\Steward\Utils\Console;

/**
 * Parser engine for eBook.
 */
class ParserEngine
{
    protected function __construct(
        protected ?BookEntityFile $file = null,
        protected ?Console $console = null,
    ) {
        $this->console = Console::make();
    }

    /**
     * Transform OPF file to ParserEngine.
     */
    public static function make(BookFileReader $file, bool $debug = false): ?BookEntity
    {
        $self = new ParserEngine();
        $entity = BookEntity::make($file);

        $self->exception(! $entity, 'entity is null');
        $self->file = $entity->file();

        $module = match ($entity->file()?->format()) {
            BookFormatEnum::cba => CbaModule::make($self, $debug),
            BookFormatEnum::epub => EpubModule::make($self, $debug),
            BookFormatEnum::pdf => PdfModule::make($self, $debug),
            default => null,
        };

        $self->exception(! $module, "{$self->file->format()->value} format is not supported");

        if (empty($module?->extractor()?->title())) {
            $parseName = config('bookshelves.parser.name');
            $message = $parseName
                ? 'Title is null, try to get title from filename'
                : 'Title is null, skip';

            $self->console->newLine();
            $self->console->print($message, 'yellow');
            $self->console->print("{$entity->file()->path()}");
            $self->console->newLine();

            if ($parseName) {
                $module = NameModule::make($self, $debug);
            }
        }

        $entity = $module?->toBookEntity($entity);

        if ($debug) {
            $self->console->print("{$entity?->title()}");
            ParserEngine::printFile($entity?->toArray(), "{$entity?->file()->name()}-parser.json");
        }

        return $entity;
    }

    public function file(): ?BookEntityFile
    {
        return $this->file;
    }

    public static function printFile(mixed $file, string $name, bool $raw = false): bool
    {
        $console = Console::make();

        try {
            $file = $raw
                ? $file
                : json_encode($file, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            return Storage::disk('public')->put("/debug/{$name}", $file);
        } catch (\Throwable $th) {
            $console->print(__METHOD__, $th);
        }

        return false;
    }

    private function exception(bool $condition, ?string $message = null)
    {
        if ($condition) {
            $this->console->newLine();
            $this->console->print("ParserEngine error, {$message}", 'red');
            $this->console->print("{$this->file?->path()}");
            $this->console->newLine();
        }
    }
}
