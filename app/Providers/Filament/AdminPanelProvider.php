<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\AssetsTable;
use App\Filament\Widgets\AssetStatsOverview;
use App\Filament\Widgets\PendingAssignments;
use App\Filament\Widgets\PendingReturns;
use App\Http\Middleware\CheckRole;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
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
use Filament\Navigation\MenuItem;
use Filament\Support\Enums\MaxWidth;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->navigationGroups([
                'Manage Assets',
                'Manage Transactions',
                'Manage Employees',
                'Manage Types',
                'Manage Statuses',
            ])
            ->widgets([
                AssetStatsOverview::class,
                Widgets\AccountWidget::class,
                PendingAssignments::class,
                PendingReturns::class,
                AssetsTable::class,
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
                CheckRole::class . ':admin',
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()->label('Edit profile'),
                // ...
            ])
            ->maxContentWidth(MaxWidth::Full)
            ->unsavedChangesAlerts()
            ->breadcrumbs(false)
            // ->sidebarCollapsibleOnDesktop()
            ->sidebarFullyCollapsibleOnDesktop()
            ->viteTheme([
                'resources/css/app.css',
            ])
            ->renderHook(
                'panels::auth.login.form.after',
                fn() => view('auth.socialite.admin-google')
            )
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s');
    }
}
