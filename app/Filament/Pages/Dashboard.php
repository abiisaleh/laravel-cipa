<?php

namespace App\Filament\Pages;

use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Blade;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Dashboard';

    protected function getHeaderActions(): array
    {
        if (auth()->user()->role == 'pimpinan')
            return [
                Action::make('print')
                    ->label('Cetak Laporan bulan ini')
                    ->icon('heroicon-s-printer')
                    ->action(function () {
                        $records = Pembayaran::whereYear('created_at', now()->year)->whereMonth('created_at',  now()->month)->get();

                        return response()->streamDownload(function () use ($records) {
                            echo Pdf::loadHtml(
                                Blade::render('pdf.report', [
                                    'subtitle' => 'Laporan transaksi penjualan bulan ' . now()->format('F'),
                                    'records' => $records,
                                    'total' => $records->sum('subtotal') + $records->sum('ongkir') + $records->sum('denda'),
                                    'cols' => [
                                        'dibuat' => 'created_at',
                                        'email' => 'user.email',
                                        'instansi' => 'user.pelanggan.instansi',
                                        'lunas' => 'lunas',
                                        'total' => 'total',
                                    ]
                                ])
                            )->setPaper('a4', 'landscape')->stream();
                        }, 'Laporan penjualan ' . now() . '.pdf');
                    }),
            ];

        return [];
    }
}
