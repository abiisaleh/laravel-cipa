<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Filament\Resources\PembayaranResource\RelationManagers;
use App\Models\Pembayaran;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make([
                        Forms\Components\Placeholder::make('dibuat')
                            ->content(fn (Pembayaran $record): string => $record->created_at->toFormattedDateString()),
                        Forms\Components\Placeholder::make('dibayar')
                            ->content(fn (Pembayaran $record): string => ($record->lunas) ? $record->tgl_lunas->toFormattedDateString() : 'xxx')
                            ->hidden(fn (Pembayaran $record) => $record->lunas),
                        Forms\Components\Placeholder::make('diterima')
                            ->content(fn (Pembayaran $record): string => ($record->lunas) ? $record->tgl_diterima->toFormattedDateString() : 'xxx')
                            ->hidden(fn (Pembayaran $record) => $record->diantar),

                        Forms\Components\Placeholder::make('instansi')
                            ->content(fn (Pembayaran $record): string => $record->instansi),
                        Forms\Components\Placeholder::make('email')
                            ->content(fn (Pembayaran $record): string => $record->pesanan->first()->user->name ?? ''),
                        Forms\Components\Placeholder::make('email')
                            ->content(fn (Pembayaran $record): string => $record->pesanan->first()->user->email ?? ''),

                        Forms\Components\Placeholder::make('metode')
                            ->content(fn (Pembayaran $record): string => $record->metode),
                        Forms\Components\Placeholder::make('ongkir')
                            ->content(fn (Pembayaran $record): string => 'Rp ' . number_format($record->ongkir)),
                        Forms\Components\Placeholder::make('total')
                            ->content(fn (Pembayaran $record): string => 'Rp ' . number_format($record->total)),
                    ])->grow()->columns(3),

                    Forms\Components\Section::make([
                        Forms\Components\Toggle::make('lunas')->disabled(fn (Pembayaran $record) => $record->metode != 'cash'),
                        Forms\Components\Toggle::make('diterima'),
                    ])->grow(false),

                ])->from('md')->grow()
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, h:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('instansi'),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->prefix('Rp ')
                    ->sortable(),
                Tables\Columns\IconColumn::make('lunas')
                    ->boolean(),
                Tables\Columns\IconColumn::make('diterima')
                    ->boolean(),
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
            RelationManagers\PesananRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembayarans::route('/'),
            'create' => Pages\CreatePembayaran::route('/create'),
            'edit' => Pages\EditPembayaran::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        if (auth()->user()->role == 'karyawan')
            return true;

        return false;
    }

    public static function canDelete(Model $record): bool
    {
        if (auth()->user()->role == 'karyawan')
            return true;

        return false;
    }

    public static function canDeleteAny(): bool
    {
        if (auth()->user()->role == 'karyawan')
            return true;

        return false;
    }
}
