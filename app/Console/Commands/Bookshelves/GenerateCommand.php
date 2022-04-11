<?php

namespace App\Console\Commands\Bookshelves;

use App\Console\CommandProd;
use App\Engines\ConverterEngine;
use App\Engines\ConverterEngine\CoverConverter;
use App\Engines\ConverterEngine\EntityConverter;
use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Parsers\FilesTypeParser;
use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\MediaExtended;
use App\Models\Serie;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use ReflectionClass;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\Tag;
use Storage;

/**
 * Main command of Bookshelves to generate Books with relations.
 */
class GenerateCommand extends CommandProd
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:generate
                            {--f|fresh : reset current books and relation, keep users}
                            {--l|limit= : limit epub files to generate, useful for debug}
                            {--d|debug : generate metadata files into public/storage/debug for debug}
                            {--D|default : use default cover for all (skip covers step)}
                            {--F|force : skip confirm in prod}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Book model with all relationships, generate covers with different dimensions.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle()
    {
        $this->intro('Books & relations');

        $force = $this->option('force') ?? false;
        $limit = str_replace('=', '', $this->option('limit'));
        $limit = intval($limit);
        $fresh = $this->option('fresh') ?? false;
        $debug = $this->option('debug') ?? false;
        $default = $this->option('default') ?? false;

        $this->checkProd();

        Artisan::call('bookshelves:clear', [], $this->getOutput());
        $list = FilesTypeParser::parseDataFiles(limit: $limit);

        if ($fresh) {
            MediaExtended::where('collection_name', MediaDiskEnum::cover)->delete();
            MediaExtended::where('collection_name', MediaDiskEnum::format)->delete();
            File::deleteDirectory(public_path('storage/media/covers'));
            File::deleteDirectory(public_path('storage/media/formats'));
            Artisan::call('database', [
                '--books' => $fresh,
            ], $this->getOutput());
        }

        if (! $list) {
            $this->alert('No files detected!');

            return false;
        }
        $this->comment('Files detected: '.sizeof($list));
        $this->info('- Generate Book model with relationships: Author, Tag, Publisher, Language, Serie');
        $this->info('- Generate new EPUB file with standard name');
        $this->newLine();
        if (! $default) {
            $format = config('bookshelves.cover_extension');
            $this->comment('Generate covers for books (--default|-D to skip)');
            $this->info('- Generate covers with differents dimensions');
            $this->info("- Main format: {$format} (original from EPUB, thumbnail)");
            $this->info('- OpenGraph, Simple format: JPG (social, Catalog)');
            if ('local' === config('app.env')) {
                $this->info('You are in local, conversions are generate only in production');
            }
            $this->newLine();
        }

        $genres = config('bookshelves.tags.genres_list');
        foreach ($genres as $genre) {
            Tag::findOrCreate($genre, 'genre');
        }

        $start = microtime(true);

        $bar = $this->output->createProgressBar(sizeof($list));
        $bar->start();
        foreach ($list as $file) {
            $parser = ParserEngine::create($file, $debug);
            ConverterEngine::convert($parser, $default);

            if (! $debug) {
                $bar->advance();
            }
        }
        $bar->finish();
        $this->newLine();

        $this->improveRelation(Author::class);
        $this->improveRelation(Serie::class);

        $this->newLine();
        $time_elapsed_secs = number_format(microtime(true) - $start, 2);
        $this->info("Time in seconds: {$time_elapsed_secs}");

        return true;
    }

    private function improveRelation(string $model)
    {
        $default = $this->option('default') ?? false;

        $class = new ReflectionClass($model);
        $class = $class->getShortName();

        $this->newLine();
        $this->warn("Improve {$class}s...");
        $this->newLine();
        $bar = $this->output->createProgressBar($model::count());
        $bar->start();
        foreach ($model::all() as $entity) {
            EntityConverter::setTags($entity);
            if (! $default) {
                CoverConverter::setLocalCover($entity);
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }
}
