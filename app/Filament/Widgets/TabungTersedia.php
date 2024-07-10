<?php

namespace App\Filament\Widgets;

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
            ->query(Tabung::query())
            ->columns([
                TextColumn::make('nama')->label('Tabung'),
                TextColumn::make('stok')
            ]);
    }
}
