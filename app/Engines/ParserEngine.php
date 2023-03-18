<?php

namespace App\Engines;

use App\Engines\Parser\Models\BookEntity;
use App\Engines\Parser\Models\BookEntityFile;
use App\Engines\Parser\Modules\CbaModule;
use App\Engines\Parser\Modules\EpubModule;
use App\Engines\Parser\Modules\NameModule;
use App\Engines\Parser\Modules\PdfModule;
use App\Engines\Parser\Parsers\BookFile;
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
    public static function make(BookFile $file, bool $debug = false): ?BookEntity
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

        if (empty($module->title())) {
            $self->console->newLine();
            $self->console->print('Title is null, try to get title from filename', 'yellow');
            $self->console->print("{$entity->file()->path()}");
            $self->console->newLine();

            $module = NameModule::make($self, $debug);
        }

        $entity = $module?->toBookEntity($entity);

        if ($debug) {
            $self->console->print("{$entity->title()}");
            ParserEngine::printFile($entity->toArray(), "{$entity->file()->name()}-parser.json");
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
