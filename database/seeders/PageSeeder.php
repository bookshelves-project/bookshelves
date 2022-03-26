<?php

namespace Database\Seeders;

use App\Enums\PostStatusEnum;
use App\Models\MediaExtended;
use App\Models\Page;
use App\Services\ConverterService;
use App\Services\MarkdownToHtmlService;
use App\Services\MediaService;
use DateTime;
use Doctrine\DBAL\Portability\Converter;
use DOMDocument;
use File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (Page::all() as $page) {
            $page->clearMediaCollection('featured-image');
            $page->clearMediaCollection('page-images');
        }
        Page::truncate();

        $list = [
            [
                'title' => 'About',
                'summary' => 'About this project',
                'status' => PostStatusEnum::published,
                'name' => 'about',
                'image' => 'about',
            ],
            [
                'title' => 'FAQ',
                'summary' => 'Frequently Asked Questions',
                'status' => PostStatusEnum::published,
                'name' => 'faq',
                'image' => 'faq',
            ],
            [
                'title' => 'Features: OPDS, Catalog & more',
                'summary' => 'On other ways',
                'status' => PostStatusEnum::published,
                'name' => 'features',
                'image' => 'features',
            ],
            [
                'title' => 'Legal',
                'summary' => 'About legal',
                'status' => PostStatusEnum::published,
                'name' => 'legal',
                'image' => 'legal',
            ],
            [
                'title' => 'More eBooks',
                'summary' => 'About more eBooks projects',
                'status' => PostStatusEnum::published,
                'name' => 'more-ebooks',
                'image' => 'more-ebooks',
            ],
            [
                'title' => 'Privacy',
                'summary' => 'Your privacy & your data',
                'status' => PostStatusEnum::published,
                'name' => 'privacy',
                'image' => 'privacy',
            ],
        ];
        $list = ConverterService::arrayToObject($list);

        foreach ($list as $md) {
            $this->getHtmlFromMd($md);
        }
    }

    public static function getHtmlFromMd(object $md)
    {
        $service = MarkdownToHtmlService::create($md, 'pages');

        if ($service) {
            $page = Page::create([
                'title' => $md->title,
                'slug' => Str::slug($md->title),
                'status' => $md->status,
                'summary' => $md->summary,
                'body' => $service->html,
                'published_at' => new DateTime(),
                'meta_title' => $md->title,
                'meta_description' => $md->summary,
            ]);

            $service->setImages($page, 'featured-image', 'page-images');
        }
    }
}
