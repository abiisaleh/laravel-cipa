<?php

namespace App\Filament\Pages;

use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Dashboard';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label('Cetak Laporan')
                ->icon('heroicon-s-printer')
                ->url('report/print')
                ->openUrlInNewTab()
        ];
    }
}
