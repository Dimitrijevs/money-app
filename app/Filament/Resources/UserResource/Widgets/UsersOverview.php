<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersOverview extends BaseWidget
{

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        $usersPerDay = [];
        for ($i = 6; $i >= 0; $i--) {
            $usersPerDay[] = User::whereDate('created_at', now()->subDays($i))->count();
        }
        return [
            Stat::make('Total users', User::count())
                ->description('Total number of users')
                ->descriptionIcon('heroicon-o-user-group', IconPosition::Before) // Before or After
                ->color('success'),
            Stat::make('New Users who jouned us last week', User::where('created_at', '>=', now()->subWeek())->count())
                ->description('New users who joined us last week')
                ->descriptionIcon('heroicon-o-user-group', IconPosition::Before)
                ->color('info')
                ->chart($usersPerDay),
        ];
    }
}
