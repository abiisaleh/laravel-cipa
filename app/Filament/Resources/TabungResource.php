<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TabungResource\Pages;
use App\Models\HargaTabung;
use App\Models\Tabung;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TabungResource extends Resource
{
    protected static ?string $model = Tabung::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationGroup = 'Gudang';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'kode';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('harga_tabung_id')
                    ->label('Tabung')
                    ->live()
                    ->afterStateUpdated(fn (Set $set, $state) => $set('kode', HargaTabung::find($state)->kode . str_pad((Tabung::where('harga_tabung_id', $state)->count() + 1), 2, '0', STR_PAD_LEFT)))
                    ->relationship('hargaTabung')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->jenisTabung->jenis} {$record->ukuranTabung->ukuran}"),
                TextInput::make('jumlah')->numeric()->default(1)->minValue(1)->maxValue(99)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode')->searchable(),
                TextColumn::make('hargaTabung.jenisTabung.jenis'),
                TextColumn::make('hargaTabung.ukuranTabung.ukuran'),
                ToggleColumn::make('active'),
                IconColumn::make('digunakan')->boolean(),
            ])
            ->filters([
                SelectFilter::make('jenis_tabung_id')
                    ->relationship('hargaTabung.jenisTabung', 'jenis')
                    ->preload()
                    ->label('Jenis'),
                SelectFilter::make('ukuran_tabung_id')
                    ->relationship('hargaTabung.jenisTabung', 'jenis')
                    ->preload()
                    ->label('Ukuran'),
                TernaryFilter::make('active'),
                TernaryFilter::make('used'),
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
            'index' => Pages\ManageTabungs::route('/'),
        ];
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }
}
