<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use ImranDevBd\AiHub\Filament\AiHubPlugin;
use ImranDevBd\AttendanceHub\Filament\AttendanceHubPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('দর্জি প্রো (DarziPro ERP)')
            ->colors([
                'primary' => Color::Emerald,
                'gray'    => Color::Slate,
            ])
            ->plugins([
                AttendanceHubPlugin::make(),
                AiHubPlugin::make(),
            ])
            ->navigationGroups([
                NavigationGroup::make('দর্জি ও অর্ডার ব্যবস্থাপনা')
                    ->icon('heroicon-o-scissors'),
                NavigationGroup::make('কারিগর ও প্রোডাকশন')
                    ->icon('heroicon-o-user-group'),
                NavigationGroup::make('ইনভেন্টরি ও গজ কাপড়')
                    ->icon('heroicon-o-archive-box'),
                NavigationGroup::make('হাজিরা ও বায়োমেট্রিক')
                    ->icon('heroicon-o-finger-print'),
                NavigationGroup::make('হিসাব ও আর্থিক রিপোর্ট')
                    ->icon('heroicon-o-banknotes'),
                NavigationGroup::make('সিস্টেম ও শাখা সেটিংস')
                    ->icon('heroicon-o-cog-6-tooth'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
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
            ]);
    }
}
