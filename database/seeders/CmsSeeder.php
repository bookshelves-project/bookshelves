<?php

namespace Database\Seeders;

use App\Enums\SpatieMediaMethodEnum;
use App\Models\Cms\Application;
use App\Models\Cms\HomePage;
use App\Models\Cms\HomePageStatistic;
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
        Application::query()->delete();

        $application = Application::create([
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
        HomePage::query()->delete();

        $home_page = HomePage::create([
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
            'statistics' => $this->homePageStatistics(),
            'logos_title' => [
                'en' => 'Special thanks to these softwares or websites because they help our work.',
                'fr' => 'Un grand merci à ces logiciels ou sites web car ils nous aident dans notre travail.',
            ],
            'logos' => [
                [
                    'label' => 'Calibre',
                    'slug' => 'calibre',
                    'link' => 'https://calibre-ebook.com',
                ],
                [
                    'label' => 'Pandoc',
                    'slug' => 'pandoc',
                    'link' => 'https://pandoc.org',
                ],
                [
                    'label' => 'Team AlexandriZ',
                    'slug' => 'team-alexandriz',
                    'link' => 'https://twitter.com/teamalexandriz',
                ],
                [
                    'label' => 'Lulu',
                    'slug' => 'lulu',
                    'link' => 'https://www.lulu.com',
                ],
                [
                    'label' => 'OPDS',
                    'slug' => 'opds',
                    'link' => 'https://opds.io',
                ],
            ],
            'features_title' => [
                'en' => 'How to use Bookshelves',
                'fr' => 'Comment utiliser Bookshelves',
            ],
            'features_text' => [
                'en' => 'Let Bookshelves guide you through hundreds of eBooks and let yourself be tempted by vast universes directly accessible by your eReader.',
                'fr' => "Laissez Bookshelves vous guider à travers des centaines d'eBooks et laissez-vous tenter par de vastes univers directement accessibles par votre liseuse.",
            ],
            'features' => [
                [
                    'title' => [
                        'en' => 'EPUB files',
                        'fr' => 'Fichiers EPUB',
                    ],
                    'text' => [
                        'en' => 'EPUB files format to be lightest as possible, a free DRM format that can be shared and edited at will, you can edit any eBook with Calibre',
                        'fr' => "Le format des fichiers EPUB pour être le plus léger possible, un format DRM gratuit qui peut être partagé et édité à volonté, vous pouvez éditer n'importe quel eBook avec Calibre.",
                    ],
                    'icon' => 'epub',
                ],
                [
                    'title' => [
                        'en' => 'Regardless of eReader',
                        'fr' => 'Pour toutes les liseuses',
                    ],
                    'text' => [
                        'en' => 'Kobo, Bookeen, Vivlio or even Kindle (with Calibre), you can use eBooks in EPUB format on many eReaders.',
                        'fr' => 'Kobo, Bookeen, Vivlio ou même Kindle (avec Calibre), vous pouvez utiliser les eBooks au format EPUB sur de nombreuses liseuses.',
                    ],
                    'icon' => 'ereader',
                ],
                [
                    'title' => [
                        'en' => 'Download & read',
                        'fr' => 'Télécharger & lire',
                    ],
                    'text' => [
                        'en' => 'Download an eBook and/or a serie of eBook add them to your eReader and start reading!',
                        'fr' => "Téléchargez un eBook et/ou une série d'eBooks, ajoutez-les à votre liseuse et commencez à lire !",
                    ],
                    'icon' => 'download',
                ],
                [
                    'title' => [
                        'en' => 'Metadata',
                        'fr' => 'Metadata',
                    ],
                    'text' => [
                        'en' => 'All these informations that allows you to sort and find your books by author or series are integrated into each eBook.',
                        'fr' => 'Toutes ces informations qui vous permettent de trier et de retrouver vos livres par auteur ou par série sont intégrées dans chaque eBook.',
                    ],
                    'icon' => 'metadata',
                ],
                [
                    'title' => [
                        'en' => 'Multi languages',
                        'fr' => 'Multilingue',
                    ],
                    'text' => [
                        'en' => 'eBooks in several languages according to your preferences in order to reach a maximum number of readers.',
                        'fr' => 'Des livres électroniques en plusieurs langues, selon vos préférences, afin de toucher un maximum de lecteurs.',
                    ],
                    'icon' => 'languages',
                ],
                [
                    'title' => [
                        'en' => 'Features: OPDS & Catalog',
                        'fr' => 'Features: OPDS & Catalog',
                    ],
                    'text' => [
                        'en' => 'Features offer you extra options: you can use OPDS feed, download eBooks from your eReader with Catalog or read an eBook in your browser with Webreader.',
                        'fr' => 'Des eBooks en plusieurs langues, selon vos préférences, afin de toucher un maximum de lecteurs.',
                    ],
                    'icon' => 'feed',
                ],
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

        /**
         * Create logos.
         */
        $logos = File::allFiles(database_path('seeders/media/cms/home-page/logos'));
        foreach ($logos as $logo) {
            $filename = pathinfo($logo->getFilename(), PATHINFO_FILENAME);
            MediaService::create($home_page, Str::slug($filename), 'cms', collection: 'cms_logos', extension: 'webp', method: SpatieMediaMethodEnum::addMediaFromString())
                ->setMedia(file_get_contents($logo->getPathname()))
                ->setColor()
            ;
        }

        /**
         * Create features.
         */
        $logos = File::allFiles(database_path('seeders/media/cms/home-page/features'));
        foreach ($logos as $logo) {
            $filename = pathinfo($logo->getFilename(), PATHINFO_FILENAME);
            MediaService::create($home_page, Str::slug($filename), 'cms', collection: 'cms_features', extension: 'svg', method: SpatieMediaMethodEnum::addMediaFromString())
                ->setMedia(file_get_contents($logo->getPathname()))
                ->setColor()
            ;
        }
    }

    private function homePageStatistics(): array
    {
        return [
            new HomePageStatistic([
                'model' => 'App\Models\Book',
                'modelWhere' => null,
                'label' => [
                    'en' => 'eBooks available',
                    'fr' => 'eBooks disponibles',
                ],
            ]),
            new HomePageStatistic([
                'model' => 'App\Models\Author',
                'modelWhere' => null,
                'label' => [
                    'en' => 'authors',
                    'fr' => 'auteur·ices',
                ],
            ]),
            new HomePageStatistic([
                'model' => 'App\Models\Serie',
                'modelWhere' => null,
                'label' => [
                    'en' => 'series',
                    'fr' => 'séries',
                ],
            ]),
            new HomePageStatistic([
                'model' => 'App\Models\Book',
                'modelWhere' => ['language_slug', 'fr'],
                'label' => [
                    'en' => 'eBooks available in french',
                    'fr' => 'eBooks disponibles en français',
                ],
            ]),
            new HomePageStatistic([
                'model' => 'App\Models\Book',
                'modelWhere' => ['language_slug', 'en'],
                'label' => [
                    'en' => 'eBooks available in english',
                    'fr' => 'eBooks disponibles en anglais',
                ],
            ]),
        ];
    }
}
