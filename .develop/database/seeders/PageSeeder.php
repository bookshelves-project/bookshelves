<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Services\ConverterService;
use App\Services\MarkdownToHtmlService;
use DateTime;
use Illuminate\Database\Seeder;
use Kiwilan\Steward\Enums\PublishStatusEnum;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Page::query()->delete();
        // foreach (Page::all() as $page) {
        //     $page->clearMediaCollection('featured-image');
        //     $page->clearMediaCollection('page-images');
        // }
        // Page::truncate();

        $list = [
            [
                'title' => 'About',
                'slug' => 'about',
                'summary' => 'About this project',
                'status' => PublishStatusEnum::published,
                'name' => 'about',
                'image' => 'about',
            ],
            [
                'title' => 'FAQ',
                'slug' => 'faq',
                'summary' => 'Frequently Asked Questions',
                'status' => PublishStatusEnum::published,
                'name' => 'faq',
                'image' => 'faq',
            ],
            [
                'title' => 'Features: OPDS, Catalog & more',
                'slug' => 'features',
                'summary' => 'On other ways',
                'status' => PublishStatusEnum::published,
                'name' => 'features',
                'image' => 'features',
            ],
            [
                'title' => 'Legal',
                'slug' => 'legal',
                'summary' => 'About legal',
                'status' => PublishStatusEnum::published,
                'name' => 'legal',
                'image' => 'legal',
            ],
            [
                'title' => 'More eBooks',
                'slug' => 'more-ebooks',
                'summary' => 'About more eBooks projects',
                'status' => PublishStatusEnum::published,
                'name' => 'more-ebooks',
                'image' => 'more-ebooks',
            ],
            [
                'title' => 'Privacy',
                'slug' => 'privacy',
                'summary' => 'Your privacy & your data',
                'status' => PublishStatusEnum::published,
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
                'slug' => $md->slug,
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
