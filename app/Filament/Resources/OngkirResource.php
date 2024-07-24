<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OngkirResource\Pages;
use App\Filament\Resources\OngkirResource\RelationManagers;
use App\Models\Ongkir;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\File;

class OngkirResource extends Resource
{
    protected static ?string $model = Ongkir::class;

    protected static ?string $modelLabel = 'Ongkos kirim';

    protected static ?string $navigationGroup = 'Data master';

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kecamatan')
                    ->native(false)
                    ->options(function () {
                        $data = File::json('kotajayapura.json');
                        foreach ($data as $key => $value) {
                            $options[$key] = $key;
                        }
                        return $options;
                    })
                    ->required(),
                Forms\Components\TextInput::make('biaya')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kecamatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('biaya')
                    ->prefix('Rp ')
                    ->numeric(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageOngkirs::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()->role == 'karyawan';
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->role == 'karyawan';
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->role == 'karyawan';
    }
}
