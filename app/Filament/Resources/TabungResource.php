<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TabungResource\Pages;
use App\Filament\Resources\TabungResource\RelationManagers;
use App\Filament\Resources\TabungResource\RelationManagers\TabungRelationManager;
use App\Models\JenisTabung;
use App\Models\Tabung;
use App\Models\UkuranTabung;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TabungResource extends Resource
{
    protected static ?string $model = Tabung::class;

    protected static ?string $pluralLabel = 'tabung';

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('jenis_tabung_id')
                    ->relationship('jenisTabung', 'jenis')
                    ->required()
                    ->createOptionForm([
                        TextInput::make('kode')->required(),
                        TextInput::make('simbol')->required(),
                        TextInput::make('jenis')->required(),
                    ])
                    ->disabled(auth()->user()->role != 'karyawan'),
                Select::make('ukuran_tabung_id')
                    ->relationship('ukuranTabung')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->ukuran} ({$record->berat}Kg)")
                    ->required()
                    ->createOptionForm([
                        TextInput::make('kode')->required(),
                        TextInput::make('ukuran')->required()
                            ->datalist([
                                'kecil',
                                'sedang',
                                'besar',
                            ]),
                        TextInput::make('berat')->suffix('Kg')->required(),
                    ])
                    ->afterStateUpdated(fn (Get $get, Set $set, $state) => $set('kode', JenisTabung::find($get('jenis_tabung_id'))->kode . UkuranTabung::find($state)->kode))
                    ->disabled(auth()->user()->role != 'karyawan'),
                Hidden::make('kode')->required(),
                Fieldset::make('Harga')
                    ->columns(3)
                    ->schema([
                        TextInput::make('harga_full')->required()->label('Full')->prefix('Rp. ')->numeric()->disabled(auth()->user()->role != 'karyawan'),
                        TextInput::make('harga_refill')->required()->label('Refill')->prefix('Rp. ')->numeric()->disabled(auth()->user()->role != 'karyawan'),
                        TextInput::make('harga_kosong')->required()->label('Kosong')->prefix('Rp. ')->numeric()->disabled(auth()->user()->role != 'karyawan'),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jenisTabung.jenis')
                    ->label('Jenis')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ukuranTabung.ukuran')
                    ->label('Ukuran')
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga_full')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga_refill')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga_kosong')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stok')
                    ->numeric()
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
            TabungRelationManager::class
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
