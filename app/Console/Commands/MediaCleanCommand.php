<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Book;
use App\Models\Content;
use App\Models\Page;
use App\Models\Post;
use App\Models\Reference;
use App\Models\Serie;
use App\Models\Service;
use App\Models\TeamMember;
use DB;
use File;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class MediaCleanCommand extends Command
{
    /** @var string[] */
    public const EXTENSIONS = [
        'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg',
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean all medias without database link, useful after delete media from back-office.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->alert($this->signature);
        $this->warn($this->description);
        $this->newLine();

        $models_list = [
            Book::class,
            Author::class,
            Serie::class,
        ];
        $media_path = public_path('storage');

        $media_entries = [];
        foreach ($models_list as $model) {
            /** @var Model $instance */
            $instance = new $model();
            $table = $instance->getTable();

            /** Parse all entries in database */
            $rows = DB::table($table)
                ->select('*')
                ->get()
            ;

            /** Extract all entries with media */
            foreach ($rows as $row) {
                foreach ($row as $entry) {
                    foreach (self::EXTENSIONS as $extension) {
                        if (str_contains($entry, ".{$extension}")) {
                            $media_entries[] = $entry;
                        }
                    }
                }
            }
        }

        /** Get all medias from $media_path */
        $files_list = File::allFiles($media_path);
        $files = [];
        foreach ($files_list as $file) {
            $file_path = $file->getRelativePathname();
            $file_path = str_replace('\\', '/', $file_path);
            $files[] = $file_path;
        }

        $media_used = [];
        $media_all = [];
        /** Find medias between used and all */
        foreach ($files as $file) {
            foreach ($media_entries as $media_entry) {
                $path = "{$media_path}/{$file}";
                if (str_contains($media_entry, $file)) {
                    $media_used[] = $path;
                } else {
                    $media_all[] = $path;
                }
            }
        }
        $media_all = array_unique($media_all);
        $media_all = array_values($media_all);

        /** Delete medias which is not used */
        foreach ($media_all as $value) {
            if (! in_array($value, $media_used)) {
                $this->warn("Media {$value} will be deleted.");
                File::delete($value);
            }
        }

        return 0;
    }
}
