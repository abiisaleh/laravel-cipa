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
            Stat::make('Tabung tersedia', StokTabung::where('active', true)->where('digunakan', false)->count())
                ->description('dari ' . StokTabung::count() . ' tabung'),
            Stat::make('Tabung rusak', StokTabung::where('active', false)->count()),
            Stat::make('Tabung digunakan', StokTabung::where('digunakan', true)->count()),
        ];
    }
}
