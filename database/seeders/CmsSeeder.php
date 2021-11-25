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
        Media::where('collection_name', 'cms_hero')->delete();
        Media::where('collection_name', 'cms_application_favicon')->delete();
        Media::where('collection_name', 'cms_application_og')->delete();
        Media::where('collection_name', 'cms_application_logo')->delete();
        Media::where('collection_name', 'cms_application_icon')->delete();
        Media::where('collection_name', 'cms_logos')->delete();
        $this->setApplication();
        $this->setHomePage();
    }

    private function setApplication()
    {
        CmsApplication::query()->delete();

        $application = CmsApplication::create([
            'name' => 'Bookshelves',
            'title_template' => '%s · Bookshelves',
            'slug' => 'bookshelves',
            'meta_title' => [
                'en' => 'Bookshelves, reading in complete tranquility...',
                'fr' => 'Bookshelves, lisez en toute tranquillité...',
            ],
            'meta_description' => [
                'en' => 'For people with eReaders, download eBooks and reading in complete tranquility, your digital library that goes everywhere with you.',
                'fr' => "Pour les personnes disposant d'une liseuse, téléchargez des eBooks et lisez en toute tranquillité, votre bibliothèque numérique qui vous accompagne partout.",
            ],
            'meta_author' => [
                'en' => 'Bookshelves Team',
                'fr' => "L'équipe Bookshelves",
            ],
            'meta_twitter_creator' => '@ewilanriviere',
            'meta_twitter_site' => '@bookshelves_ink',
        ]);

        MediaService::create($application, "{$application->slug}-favicon", 'cms', collection: 'cms_application_favicon', extension: 'svg')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/favicon.svg'))))
            ->setColor()
        ;

        MediaService::create($application, "{$application->slug}-icon", 'cms', collection: 'cms_application_icon', extension: 'svg')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/icon.svg'))))
            ->setColor()
        ;

        MediaService::create($application, "{$application->slug}-logo", 'cms', collection: 'cms_application_logo', extension: 'png')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/icon.png'))))
            ->setColor()
        ;

        MediaService::create($application, "{$application->slug}-og", 'cms', collection: 'cms_application_og', extension: 'jpg')
            ->setMedia(base64_encode(File::get(database_path('seeders/media/cms/open_graph.jpg'))))
            ->setColor()
        ;
    }

    private function setHomePage()
    {
        CmsHomePage::query()->delete();

        $home_page = CmsHomePage::create([
            'hero_title' => [
                'en' => 'reading in complete tranquility...',
                'fr' => 'lire en toute tranquilité...',
            ],
            'hero_text' => [
                'en' => "If you have an eReader and are looking for plenty of eBooks to take everywhere with you, you've come to the right place, hours of reading in perspective.",
                'fr' => 'Si vous possédez une liseuse et que vous recherchez de nombreux eBooks à emporter partout avec vous, vous êtes au bon endroit, des heures de lecture en perspective.',
            ],
            'statistics_eyebrow' => [
                'en' => 'A quick tour of eBooks count',
                'fr' => "Un rapide tour d'horizon du nombre d'eBooks",
            ],
            'statistics_title' => [
                'en' => 'Lots of ebooks for ever more insatiable readers',
                'fr' => 'De nombreux ebooks pour des lecteur·ice·s toujours plus insatiables',
            ],
            'statistics_text' => [
                'en' => "More and more eBooks for more and more reading, each day brings its own novelties (or almost). Don't hesitate to come back from time to time to discover the new books.",
                'fr' => "Toujours plus d'eBooks pour toujours plus de lecture, chaque jour apporte son lot de nouveautés (ou presque). nouveautés (ou presque). N'hésitez pas à revenir de temps en temps pour découvrir les nouveaux livres. temps pour découvrir les nouveaux livres.",
            ],
            'logos_title' => [
                'en' => 'Special thanks to these softwares or websites because they help our work.',
                'fr' => 'Un grand merci à ces logiciels ou sites web car ils nous aident dans notre travail.',
            ],
            'features_title' => [
                'en' => 'How to use Bookshelves',
                'fr' => 'Comment utiliser Bookshelves',
            ],
            'features_text' => [
                'en' => 'Let Bookshelves guide you through hundreds of eBooks and let yourself be tempted by vast universes directly accessible by your eReader.',
                'fr' => "Laissez Bookshelves vous guider à travers des centaines d'eBooks et laissez-vous tenter par de vastes univers directement accessibles par votre liseuse.",
            ],
            'display_statistics' => true,
            'display_logos' => true,
            'display_features' => true,
            'display_latest' => true,
            'display_selection' => true,
        ]);

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

            $logo = File::get(database_path("seeders/media/cms/home-page/features/{$raw['icon']}.svg"));
            MediaService::create($model, Str::slug($raw['icon']), 'cms', collection: 'cms_features', extension: 'svg', method: SpatieMediaMethodEnum::addMediaFromString())
                ->setMedia($logo)
                ->setColor()
            ;
        }
    }
}
