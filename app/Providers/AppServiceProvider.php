<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Filament::registerRenderHook(
            'panels::head.end',
            fn(): string => '
                <link rel="apple-touch-icon" sizes="180x180" href="' . asset('apple-touch-icon.png') . '">
                <link rel="icon" type="image/png" sizes="32x32" href="' . asset('favicon-32x32.png') . '">
                <link rel="icon" type="image/png" sizes="16x16" href="' . asset('favicon-16x16.png') . '">
                <link rel="manifest" href="' . asset('site.webmanifest') . '">
            '
        );
    }
}
