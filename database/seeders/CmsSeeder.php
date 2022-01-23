<?php

namespace Database\Seeders;

use App\Enums\SpatieMediaMethodEnum;
use App\Models\Cms\CmsApplication;
use App\Models\Cms\CmsHomePage;
use App\Models\Cms\CmsHomePageFeature;
use App\Models\Cms\CmsHomePageHighlight;
use App\Models\Cms\CmsHomePageLogo;
use App\Models\Cms\CmsHomePageStatistic;
use App\Services\FileService;
use App\Services\MediaService;
use App\Services\SvgService;
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

    private function getData(string $name)
    {
        return FileService::jsonToArray(database_path("seeders/data/cms/{$name}.json"));
    }

    private function setApplication()
    {
        CmsApplication::query()->delete();

        $application = CmsApplication::create($this->getData('CmsApplication'));

        /*
         * Set favicon.
         */
        MediaService::create($application, "{$application->slug}-favicon", 'cms', collection: 'cms_application_favicon', extension: 'svg')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/favicon.svg'))))
            ->setColor()
        ;

        /*
         * Set icon.
         */
        MediaService::create($application, "{$application->slug}-icon", 'cms', collection: 'cms_application_icon', extension: 'svg')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/icon.svg'))))
            ->setColor()
        ;

        /*
         * Set logo.
         */
        MediaService::create($application, "{$application->slug}-logo", 'cms', collection: 'cms_application_logo', extension: 'png')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/icon.png'))))
            ->setColor()
        ;

        /*
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
        CmsHomePageLogo::query()->delete();
        CmsHomePageFeature::query()->delete();
        CmsHomePageStatistic::query()->delete();
        CmsHomePageHighlight::query()->delete();

        $home_page = CmsHomePage::create($this->getData('CmsHomePage'));

        MediaService::create($home_page, 'cms_hero', 'cms', collection: 'cms_hero', extension: 'svg')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/home-page/hero.svg'))))
            ->setColor()
        ;

        $this->setHomePageStatistics();
        $this->setHomePageLogos();
        $this->setHomePageFeatures();
        $this->setHomePageHighlight();
    }

    private function setHomePageStatistics()
    {
        $homePage = CmsHomePage::first();
        foreach ($this->getData('CmsHomePageStatistic') as $raw) {
            $model = CmsHomePageStatistic::create($raw);
            $model->homePage()->associate($homePage);
            $model->save();
        }
    }

    private function setHomePageLogos()
    {
        $homePage = CmsHomePage::first();
        foreach ($this->getData('CmsHomePageLogo') as $raw) {
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
        $homePage = CmsHomePage::first();
        foreach ($this->getData('CmsHomePageFeature') as $raw) {
            $model = CmsHomePageFeature::create($raw);
            $model->homePage()->associate($homePage);
            $model->save();

            $logo = SvgService::setColor(database_path("seeders/media/cms/home-page/front/{$raw['slug']}.svg"), $raw['slug'], '#ffffff');
            MediaService::create($model, Str::slug($raw['slug']), 'cms', collection: 'cms_features', extension: 'svg', method: SpatieMediaMethodEnum::addMediaFromString())
                ->setMedia($logo)
                ->setColor()
            ;
        }
    }

    private function setHomePageHighlight()
    {
        $homePage = CmsHomePage::first();
        foreach ($this->getData('CmsHomePageHighlight') as $raw) {
            $model = CmsHomePageHighlight::create($raw);
            $model->homePage()->associate($homePage);
            $model->save();

            $icon = SvgService::setColor(database_path("seeders/media/cms/home-page/highlight/icon-{$raw['slug']}.svg"), 'icon-'.$raw['slug'], '#564fcc');
            MediaService::create($model, Str::slug($raw['slug']), 'cms', collection: 'cms_highlights_icons', extension: 'svg', method: SpatieMediaMethodEnum::addMediaFromString())
                ->setMedia($icon)
                ->setColor()
            ;

            $picture = File::get(database_path("seeders/media/cms/home-page/highlight/{$raw['slug']}.svg"));
            MediaService::create($model, Str::slug($raw['slug']), 'cms', collection: 'cms_highlights', extension: 'svg', method: SpatieMediaMethodEnum::addMediaFromString())
                ->setMedia($picture)
                ->setColor()
            ;
        }
    }
}
