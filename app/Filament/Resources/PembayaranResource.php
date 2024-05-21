<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Filament\Resources\PembayaranResource\RelationManagers;
use App\Models\Pembayaran;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static ?string $modelLabel = 'Pesanan';

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        $countLunas = static::getModel()::where('lunas', false)->count();
        $countDiantar = static::getModel()::where(fn ($query) => $query->where('metode', 'cash')->where('diterima', false))
            ->orWhere(fn ($query) => $query->whereNot('metode', 'cash')->where('lunas', true)->where('diterima', false))
            ->count();

        if (auth()->user()->role == 'karyawan')
            return $countLunas == 0 ? '' : $countLunas;
        if (auth()->user()->role == 'petugas')
            return $countDiantar == 0 ? '' : $countDiantar;

        return $countDiantar + $countLunas == 0 ? '' : $countDiantar + $countLunas;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make([
                        Forms\Components\Placeholder::make('dibuat')
                            ->content(fn (Pembayaran $record): string => $record->created_at->toFormattedDateString()),
                        Forms\Components\Placeholder::make('dibayar')
                            ->content(fn (Pembayaran $record): string => ($record->lunas) ? $record->tgl_lunas : 'xxx')
                            ->hidden(fn (Pembayaran $record) => $record->lunas),
                        Forms\Components\Placeholder::make('diterima')
                            ->content(fn (Pembayaran $record): string => ($record->diterima) ? $record->tgl_diterima : 'xxx')
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
                        Forms\Components\Toggle::make('lunas')->disabled(function (Pembayaran $record) {
                            if (auth()->user()->role == 'petugas')
                                return true;

                            return $record->metode != 'cash';
                        }),
                        Forms\Components\Toggle::make('diterima')->disabled(auth()->user()->role != 'petugas'),
                    ])->grow(false)->hidden(auth()->user()->role == 'pimpinan'),

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
                Tables\Columns\TextColumn::make('metode')->badge()->color(fn (string $state) => $state == 'cash' ? 'success' : 'primary'),
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
                Filter::make('Cash')->query(fn (Builder $query) => $query->where('metode', 'cash'))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->role != 'petugas';
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}
