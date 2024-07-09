<?php

namespace App\Filament\Resources\TabungResource\Widgets;

use App\Models\Tabung;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TabungOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total tabung', Tabung::all()->count()),
            Stat::make('Tabung active', Tabung::where('active', true)->count()),
            Stat::make('Tabung tersedia', Tabung::where('digunakan', false)->count()),
        ];
    }
}
