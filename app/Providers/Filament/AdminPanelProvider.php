<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Wedding Admin Panel')
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth('full')
            ->colors([
                'primary' => Color::Amber,
                'gray' => Color::Zinc,
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                fn (): HtmlString => new HtmlString('
                    <script src="https://cdn.tailwindcss.com"></script>
                    <script>
                        if (typeof tailwind !== "undefined") {
                            tailwind.config = {
                                darkMode: "class",
                                theme: {
                                    extend: {
                                        colors: {
                                            primary: {
                                                50: "#fffbeb",
                                                100: "#fef3c7",
                                                200: "#fde68a",
                                                300: "#fcd34d",
                                                400: "#fbbf24",
                                                500: "#f59e0b",
                                                600: "#d97706",
                                                700: "#b45309",
                                                800: "#92400e",
                                                900: "#78350f",
                                                950: "#451a03",
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    </script>
                ')
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): HtmlString => new HtmlString('
                    <style>
                        /* Frontend Professional Mobile Optimization for Filament Admin */
                        @media (max-width: 768px) {
                            /* Smooth touch scrolling with momentum */
                            .fi-ta-content, .fi-ta-table-container {
                                -webkit-overflow-scrolling: touch !important;
                                scroll-behavior: smooth !important;
                            }
                            
                            /* Touch target ergonomics (minimum 40px) */
                            .fi-btn, .fi-icon-btn, .fi-ta-actions button, .fi-ta-actions a {
                                min-height: 2.5rem;
                                touch-action: manipulation;
                            }
                            
                            .fi-icon-btn {
                                min-width: 2.5rem;
                                display: inline-flex;
                                align-items: center;
                                justify-content: center;
                            }
                            
                            /* Compact, high-readability stats on phone screens */
                            .fi-wi-stats-overview-stat {
                                padding: 0.75rem 1rem !important;
                                border-radius: 0.875rem !important;
                            }
                            
                            .fi-wi-stats-overview-stat-value {
                                font-size: 1.375rem !important;
                                line-height: 1.75rem !important;
                                font-weight: 800 !important;
                            }
                            
                            /* Form fields & action spacing on small devices */
                            .fi-fo-field-wrp {
                                margin-bottom: 0.875rem;
                            }
                            
                            /* Modal improvements for mobile viewports */
                            .fi-modal-window {
                                margin: 0.5rem !important;
                                max-height: calc(100dvh - 1rem) !important;
                                border-radius: 1.25rem !important;
                            }

                            /* Table cell padding optimization for high density on mobile */
                            .fi-ta-cell {
                                padding-top: 0.625rem !important;
                                padding-bottom: 0.625rem !important;
                            }

                            /* Bottom safe-area padding for iPhone Home Indicator & Android gesture bar */
                            body {
                                padding-bottom: env(safe-area-inset-bottom, 0px);
                            }
                        }
                    </style>
                ')
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\StatsOverview::class,
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
