<?php

namespace Database\Seeders;

use App\Enums\SpatieMediaMethodEnum;
use App\Models\Cms\CmsApplication;
use App\Models\Cms\CmsHomePage;
use App\Models\Cms\CmsHomePageFeature;
use App\Models\Cms\CmsHomePageLogo;
use App\Models\Cms\CmsHomePageStatistic;
use App\Services\FileService;
use App\Services\MediaService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $collections = [
            'cms_hero',
            'cms_application_favicon',
            'cms_application_og',
            'cms_application_logo',
            'cms_application_icon',
            'cms_logos',
            'cms_features',
        ];
        foreach ($collections as $collection) {
            Media::where('collection_name', $collection)->delete();
        }

        $this->setApplication();
        $this->setHomePage();
    }

    private function setApplication()
    {
        CmsApplication::query()->delete();

        $data = FileService::jsonToArray(database_path('seeders/data/cms/CmsApplication.json'));

        $application = CmsApplication::create($data);

        /**
         * Set favicon.
         */
        MediaService::create($application, "{$application->slug}-favicon", 'cms', collection: 'cms_application_favicon', extension: 'svg')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/favicon.svg'))))
            ->setColor()
        ;

        /**
         * Set icon.
         */
        MediaService::create($application, "{$application->slug}-icon", 'cms', collection: 'cms_application_icon', extension: 'svg')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/icon.svg'))))
            ->setColor()
        ;

        /**
         * Set logo.
         */
        MediaService::create($application, "{$application->slug}-logo", 'cms', collection: 'cms_application_logo', extension: 'png')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/icon.png'))))
            ->setColor()
        ;

        /**
         * Set OpenGraph.
         */
        MediaService::create($application, "{$application->slug}-og", 'cms', collection: 'cms_application_og', extension: 'jpg')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/open_graph.jpg'))))
            ->setColor()
        ;
    }

    private function setHomePage()
    {
        CmsHomePage::query()->delete();

        $data = FileService::jsonToArray(database_path('seeders/data/cms/CmsHomePage.json'));

        $home_page = CmsHomePage::create($data);

        MediaService::create($home_page, 'cms_hero', 'cms', collection: 'cms_hero', extension: 'svg')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/home-page/hero.svg'))))
            ->setColor()
        ;

        $this->setHomePageStatistics();
        $this->setHomePageLogos();
        $this->setHomePageFeatures();
    }

    private function setHomePageStatistics()
    {
        $data = FileService::jsonToArray(database_path('seeders/data/cms/CmsHomePageStatistic.json'));

        $homePage = CmsHomePage::first();
        foreach ($data as $raw) {
            $model = CmsHomePageStatistic::create($raw);
            $model->homePage()->associate($homePage);
            $model->save();
        }
    }

    private function setHomePageLogos()
    {
        $data = FileService::jsonToArray(database_path('seeders/data/cms/CmsHomePageLogo.json'));
        $homePage = CmsHomePage::first();
        foreach ($data as $raw) {
            $model = CmsHomePageLogo::create($raw);
            $model->homePage()->associate($homePage);
            $model->save();

            $logo = File::get(database_path("seeders/media/cms/home-page/logos/{$raw['slug']}.webp"));
            MediaService::create($model, Str::slug($raw['slug']), 'cms', collection: 'cms_logos', extension: 'webp', method: SpatieMediaMethodEnum::addMediaFromString())
                ->setMedia($logo)
                ->setColor()
            ;
        }
    }

    private function setHomePageFeatures()
    {
        $data = FileService::jsonToArray(database_path('seeders/data/cms/CmsHomePageFeature.json'));

        $homePage = CmsHomePage::first();
        foreach ($data as $raw) {
            $model = CmsHomePageFeature::create([
                'title' => $raw['title'],
                'text' => $raw['text'],
            ]);
            $model->homePage()->associate($homePage);
            $model->save();

            $logo = File::get(database_path("seeders/media/cms/home-page/features/{$raw['slug']}.svg"));
            MediaService::create($model, Str::slug($raw['slug']), 'cms', collection: 'cms_features', extension: 'svg', method: SpatieMediaMethodEnum::addMediaFromString())
                ->setMedia($logo)
                ->setColor()
            ;
        }
    }
}
