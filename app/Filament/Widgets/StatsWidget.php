<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\Message;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
            ->description('les nouveaux utilisateurs de la plateforme')
            ->chart([0, 40, User::count()])
            ->color('success'),

            Stat::make('Total Events', Event::count())
            ->description('les nouveaux evenements de la plateforme')
            ->chart([0, 10, Event::count()])
            ->color('info'),

            Stat::make('Total Messages', Message::count())
            ->description('les nouveaux messages de la plateforme')
            ->chart([0, 50, Message::count()])
            ->color('danger'),

        ];
    }
}