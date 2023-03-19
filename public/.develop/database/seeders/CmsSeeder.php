<?php

namespace Database\Seeders;

use App\Enums\MediaDiskEnum;
use App\Models\Cms\Application;
use App\Models\Cms\HomePage\HomePage;
use App\Models\Cms\HomePage\HomePageFeature;
use App\Models\Cms\HomePage\HomePageHighlight;
use App\Models\Cms\HomePage\HomePageLogo;
use App\Models\Cms\HomePage\HomePageStatistic;
use App\Models\Cms\Navigation;
use App\Services\SvgService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Kiwilan\Steward\Enums\SpatieMediaMethodEnum;
use Kiwilan\Steward\Services\ConverterService;
use Kiwilan\Steward\Services\MediaService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CmsSeeder extends Seeder
{
    public const DISK = MediaDiskEnum::cms;

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

        $this->setNavigation();
        $this->setApplication();
        $this->setHomePage();
    }

    private function getJson(string $name)
    {
        return ConverterService::jsonToArray(database_path("seeders/data/cms/{$name}.json"));
    }

    private function setNavigation()
    {
        Navigation::query()->delete();

        $navigations = $this->getJson('Navigation');

        foreach ($navigations as $navigation) {
            Navigation::create($navigation);
        }
    }

    private function setApplication()
    {
        Application::query()->delete();

        $application = Application::create($this->getJson('Application'));

        // Set favicon.
        MediaService::make($application, "{$application->slug}-favicon", self::DISK, collection: 'cms_application_favicon', extension: 'svg')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/favicon.svg'))))
            ->setColor()
        ;

        // Set icon.
        MediaService::make($application, "{$application->slug}-icon", self::DISK, collection: 'cms_application_icon', extension: 'svg')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/icon.svg'))))
            ->setColor()
        ;

        // Set logo.
        MediaService::make($application, "{$application->slug}-logo", self::DISK, collection: 'cms_application_logo', extension: 'png')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/icon.png'))))
            ->setColor()
        ;

        // Set OpenGraph.
        MediaService::make($application, "{$application->slug}-og", self::DISK, collection: 'cms_application_og', extension: 'jpg')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/open_graph.jpg'))))
            ->setColor()
        ;
    }

    private function setHomePage()
    {
        HomePage::query()->delete();
        HomePageLogo::query()->delete();
        HomePageFeature::query()->delete();
        HomePageStatistic::query()->delete();
        HomePageHighlight::query()->delete();

        $home_page = HomePage::create($this->getJson('HomePage'));

        MediaService::make($home_page, 'cms_hero', self::DISK, collection: 'cms_hero', extension: 'svg')
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
        $homePage = HomePage::first();

        foreach ($this->getJson('HomePageStatistic') as $raw) {
            $model = HomePageStatistic::create($raw);
            $model->homePage()->associate($homePage);
            $model->save();
        }
    }

    private function setHomePageLogos()
    {
        $homePage = HomePage::first();

        foreach ($this->getJson('HomePageLogo') as $raw) {
            $model = HomePageLogo::create($raw);
            $model->homePage()->associate($homePage);
            $model->save();

            $logo = File::get(database_path("seeders/media/cms/home-page/logos/{$raw['slug']}.webp"));
            MediaService::make($model, Str::slug($raw['slug']), self::DISK, collection: 'cms_logos', extension: 'webp', method: SpatieMediaMethodEnum::addMediaFromString)
                ->setMedia($logo)
                ->setColor()
            ;
        }
    }

    private function setHomePageFeatures()
    {
        $homePage = HomePage::first();

        foreach ($this->getJson('HomePageFeature') as $raw) {
            $model = HomePageFeature::create($raw);
            $model->homePage()->associate($homePage);
            $model->save();

            // $logo = SvgService::setColor(database_path("seeders/media/cms/home-page/features/{$raw['slug']}.svg"), $raw['slug'], '#ffffff');
            // MediaService::make($model, Str::slug($raw['slug']), self::DISK, collection: 'cms_features', extension: 'svg', method: SpatieMediaMethodEnum::addMediaFromString)
            //     ->setMedia($logo)
            //     ->setColor()
            // ;
        }
    }

    private function setHomePageHighlight()
    {
        $homePage = HomePage::first();

        foreach ($this->getJson('HomePageHighlight') as $raw) {
            $model = HomePageHighlight::create($raw);
            $model->homePage()->associate($homePage);
            $model->save();

            // $icon = SvgService::setColor(database_path("seeders/media/cms/home-page/highlight/icon-{$raw['slug']}.svg"), 'icon-'.$raw['slug'], '#564fcc');
            // MediaService::make($model, Str::slug($raw['slug']), self::DISK, collection: 'cms_highlights_icons', extension: 'svg', method: SpatieMediaMethodEnum::addMediaFromString)
            //     ->setMedia($icon)
            //     ->setColor()
            // ;

            $picture = File::get(database_path("seeders/media/cms/home-page/highlight/{$raw['slug']}.svg"));
            MediaService::make($model, Str::slug($raw['slug']), self::DISK, collection: 'cms_highlights', extension: 'svg', method: SpatieMediaMethodEnum::addMediaFromString)
                ->setMedia($picture)
                ->setColor()
            ;
        }
    }
}
