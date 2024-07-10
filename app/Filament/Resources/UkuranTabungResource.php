<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UkuranTabungResource\Pages;
use App\Filament\Resources\UkuranTabungResource\RelationManagers;
use App\Models\UkuranTabung;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UkuranTabungResource extends Resource
{
    protected static ?string $model = UkuranTabung::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';

    protected static ?string $navigationGroup = 'Data master';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                TextInput::make('kode')->required(),
                TextInput::make('ukuran')->required()
                    ->datalist([
                        'kecil',
                        'sedang',
                        'besar',
                    ]),
                TextInput::make('berat')->suffix('Kg')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode'),
                TextColumn::make('ukuran'),
                TextColumn::make('berat')->suffix('Kg'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUkuranTabungs::route('/'),
        ];
    }
}
