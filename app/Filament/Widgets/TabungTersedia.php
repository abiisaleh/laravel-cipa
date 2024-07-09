<?php

namespace App\Filament\Widgets;

use App\Models\HargaTabung;
use App\Models\Tabung;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TabungTersedia extends BaseWidget
{
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(HargaTabung::query())
            ->columns([
                TextColumn::make('nama')->label('Tabung'),
                TextColumn::make('stok')->sortable()
            ]);
        // ])->defaultSort('stok', 'desc');
    }
}
