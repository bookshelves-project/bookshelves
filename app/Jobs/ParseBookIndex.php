<?php

namespace App\Jobs;

use App\Engines\Book\IndexationEngine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class ParseBookIndex implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (! File::exists(IndexationEngine::indexPath())) {
            throw new \Exception('Index file not found!');
        }

        $index = IndexationEngine::make();

        $books = [];
        $authors = [];
        $tags = [];
        $series = [];
        $publishers = [];
        $languages = [];

        foreach ($index->items() as $item) {
            $books[] = $item->book();
            $authors[] = $item->authors();
            $tags[] = $item->tags();
            $series[] = $item->serie();
            $publishers[] = $item->publisher();
            $languages[] = $item->language();
        }

        // Book::insert($books);
        // Author::insert($index->flattenAndUnique($authors));
        // Serie::insert($index->unique($series));
        // Publisher::insert($index->unique($publishers));
        // Language::insert($index->unique($languages));
        // $this->info('Books inserted!');

        // $relations = [];
        // foreach ($index as $value) {
        //     $item = $index->item($value, 'relations');
        //     $relations[$item['id']] = $item;
        // }
        // dump($relations);

        // $authors = [];

        // foreach ($relations as $key => $value) {
        //     $id = $value['id'];
        //     $authors[$id] = $index->flattenAndUniques($value['authors']);
        // }
        // dump($authors);

        // foreach ($authors as $author) {
        //     unset($author['title']);
        //     Author::insert($author);
        // }
    }
}
