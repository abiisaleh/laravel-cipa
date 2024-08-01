<?php

namespace App\Filament\Resources\TabungResource\Widgets;

use App\Models\Tabung;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StokOverview extends BaseWidget
{
    public Tabung $record;

    protected function getStats(): array
    {
        return [
            Stat::make('Tabung tersedia', $this->record->stokTabung()->where('active', true)->where('digunakan', false)->count())
                ->description('dari ' . $this->record->stokTabung()->count() . ' tabung'),
            Stat::make('Tabung rusak', $this->record->stokTabung()->where('active', false)->count()),
            Stat::make('Tabung digunakan', $this->record->stokTabung()->where('digunakan', true)->count()),
        ];
    }
}
