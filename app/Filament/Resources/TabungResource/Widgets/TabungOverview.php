<?php

namespace App\Filament\Resources\TabungResource\Widgets;

use App\Models\StokTabung;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TabungOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total tabung', StokTabung::all()->count()),
            Stat::make('Tabung rusak', StokTabung::where('active', false)->count()),
            Stat::make('Tabung tersedia', StokTabung::where('digunakan', false)->count()),
        ];
    }
}
