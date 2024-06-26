<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Dashboard';

    protected function getHeaderActions(): array
    {
        if (auth()->user()->role == 'pimpinan')
            return [
                Action::make('print')
                    ->label('Cetak Laporan')
                    ->icon('heroicon-s-printer')
                    ->form([
                        Grid::make()->schema([
                            DatePicker::make('dari')->native(false)->maxDate(now()->subWeek())->default(now()->subMonth()),
                            DatePicker::make('sampai')->native(false)->maxDate(now()->addDay())->default(now()->addDay()),
                        ])
                    ])
                    ->action(function (array $data) {
                        return redirect(url('report/print', $data));
                    })
            ];

        return [];
    }
}
