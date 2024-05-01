<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TabungResource\Pages;
use App\Filament\Resources\TabungResource\RelationManagers;
use App\Models\Tabung;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TabungResource extends Resource
{
    protected static ?string $model = Tabung::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $pluralLabel = 'Tabung';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('jenis')->options(
                    [
                        'oksigen' => 'Oksigen',
                        'nitrogen' => 'Nitrogen'
                    ]
                ),
                Select::make('ukuran')->options(
                    [
                        'kecil' => 'Kecil',
                        'sedang' => 'Sedang',
                        'besar' => 'Besar'
                    ]
                ),
                TextInput::make('harga_full')->prefix('Rp. ')->numeric(),
                TextInput::make('harga_refill')->prefix('Rp. ')->numeric(),
                TextInput::make('harga_kosong')->prefix('Rp. ')->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode'),
                TextColumn::make('jenis'),
                TextColumn::make('ukuran'),
                TextColumn::make('harga_full')->prefix('Rp. ')->numeric(),
                TextColumn::make('harga_refill')->prefix('Rp. ')->numeric(),
                TextColumn::make('harga_kosong')->prefix('Rp. ')->numeric(),
                TextColumn::make('stok')->numeric(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTabungs::route('/'),
            'create' => Pages\CreateTabung::route('/create'),
            'edit' => Pages\EditTabung::route('/{record}/edit'),
        ];
    }
}
