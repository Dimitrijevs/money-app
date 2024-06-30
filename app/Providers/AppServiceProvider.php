<?php

namespace App\Providers;

use App\Models\User;
use Filament\Facades\Filament;
use App\Observers\TaskObserver;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationGroup;

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
        Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Posts')
                    ->icon('heroicon-o-newspaper'),
                NavigationGroup::make()
                    ->label('Transactions')
                    ->icon('heroicon-o-currency-euro'),
                NavigationGroup::make()
                    ->label('Settings')
                    ->icon('heroicon-o-cog'),
            ]);
        });

        User::observe(TaskObserver::class);
    }
}
