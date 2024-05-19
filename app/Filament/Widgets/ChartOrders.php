<?php

namespace App\Filament\Widgets;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use Filament\Widgets\ChartWidget;

class ChartOrders extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pendapatan';

    protected function getData(): array
    {
        $dataSemua = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        Pembayaran::whereYear('created_at', now()->year)
            ->where('lunas', true)
            ->selectRaw('MONTH(created_at) as bulan, SUM(subtotal) as total_biaya')
            ->groupBy('bulan')
            ->get()
            ->each(function ($item) use (&$dataSemua) {
                $dataSemua[$item->bulan - 1] = $item->total_biaya;
            });

        return [
            'datasets' => [
                [
                    'label' => 'Semua',
                    'data' => $dataSemua,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
