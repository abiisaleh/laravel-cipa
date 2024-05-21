<?php

namespace App\Filament\Widgets;

use App\Models\Pelanggan;
use App\Models\Pembayaran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        return [
            Stat::make('Pendapatan bulanan', 'Rp ' . number_format(Pembayaran::whereBetween('tgl_lunas', [now()->startOfMonth(), now()->endOfMonth()])->sum('subtotal') + Pembayaran::whereBetween('tgl_lunas', [now()->startOfMonth(), now()->endOfMonth()])->sum('ongkir')))
                ->description('dari Rp ' . number_format(Pembayaran::all()->sum('subtotal') + Pembayaran::all()->sum('ongkir'))),
            Stat::make('Pesanan bulanan', Pembayaran::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count())
                ->description('dari ' . Pembayaran::all()->count()),
            Stat::make('Total Pelanggan', Pelanggan::where('verified', true)->count())
                ->description(Pelanggan::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count() . ' bergabung bulan ini'),
        ];
    }
}
