<?php

namespace App\Filament\Widgets;

use App\Models\Tabung;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TabungTersedia extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Tabung::query()->where('stok', '>', 0))
            ->columns([
                TextColumn::make('fullName')->label('Jenis'),
                TextColumn::make('stok')->sortable()
            ])->defaultSort('stok', 'desc');
    }
}
