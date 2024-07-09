<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisTabungResource\Pages;
use App\Filament\Resources\JenisTabungResource\RelationManagers;
use App\Models\JenisTabung;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JenisTabungResource extends Resource
{
    protected static ?string $model = JenisTabung::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye-dropper';

    protected static ?string $navigationGroup = 'Gudang';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                TextInput::make('kode')->required(),
                TextInput::make('simbol')->required(),
                TextInput::make('jenis')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode'),
                TextColumn::make('simbol'),
                TextColumn::make('jenis'),
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
            'index' => Pages\ManageJenisTabungs::route('/'),
        ];
    }
}
