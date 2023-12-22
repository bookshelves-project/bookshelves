<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Resources\AuthorResource;
use App\Filament\Resources\BookResource;
use App\Filament\Resources\SerieResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->colors([
                'primary' => Color::Purple,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make()
                        ->items([
                            NavigationItem::make('Dashboard')
                                ->icon('heroicon-o-home')
                                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                                ->url(fn (): string => Dashboard::getUrl()),
                            ...AuthorResource::getNavigationItems(),
                            ...BookResource::getNavigationItems(),
                            ...SerieResource::getNavigationItems(),
                            // ...SubmissionResource::getNavigationItems(),
                            // ...ManageGeneral::getNavigationItems(),
                        ]),
                    // NavigationGroup::make('Podcast')
                    //     ->items([
                    //         ...FeedResource::getNavigationItems(),
                    //         ...PodcastResource::getNavigationItems(),
                    //         ...SeasonResource::getNavigationItems(),
                    //         ...ChronicleResource::getNavigationItems(),
                    //     ]),
                    // NavigationGroup::make('Blog')
                    //     ->items([
                    //         ...PostResource::getNavigationItems(),
                    //         ...TagResource::getNavigationItems(),
                    //         ...GalleryItemResource::getNavigationItems(),
                    //         ...CommentResource::getNavigationItems(),
                    //     ]),
                    // NavigationGroup::make('Pages')
                    //     ->items([
                    //         ...ManageHome::getNavigationItems(),
                    //         ...ManageChronicles::getNavigationItems(),
                    //         ...ManagePqd2p::getNavigationItems(),
                    //         ...ManageSubmission::getNavigationItems(),
                    //         ...PageResource::getNavigationItems(),
                    //     ]),
                ]);
            });
    }
}
