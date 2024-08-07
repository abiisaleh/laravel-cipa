<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Filament\Resources\PembayaranResource\RelationManagers;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static ?string $modelLabel = 'Pesanan';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        $countLunas = static::getModel()::where(fn ($query) => $query->where('metode', 'Cash')->where('diterima', true)->where('lunas', false))
            ->orWhere(fn ($query) => $query->whereNot('metode', 'Cash')->where('lunas', false))->count();

        $countDiantar = static::getModel()::where(fn ($query) => $query->where('metode', 'Cash')->where('diterima', false))
            ->orWhere(fn ($query) => $query->whereNot('metode', 'Cash')->where('lunas', true)->where('diterima', false))
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
                    Forms\Components\Group::make([
                        Forms\Components\Section::make([
                            Forms\Components\Placeholder::make('dibuat')
                                ->content(fn (Pembayaran $record): string => $record->created_at),
                            Forms\Components\Placeholder::make('dibayar')
                                ->content(fn (Pembayaran $record): string => ($record->lunas) ? $record->tgl_lunas : 'xxx'),
                            Forms\Components\Placeholder::make('diterima')
                                ->content(fn (Pembayaran $record): string => ($record->diterima) ? $record->tgl_diterima : 'xxx')

                        ])->grow()->columns(3),

                        Forms\Components\Section::make([
                            Forms\Components\Placeholder::make('pemesan')
                                ->content(function (Pembayaran $record) {
                                    return str(
                                        '<div class="flex items-center">
                                            <img class="w-9 h-9 rounded-full" src="' . filament()->getUserAvatarUrl($record->user) . '"
                                            alt="user photo">
                                            <div class="px-2">
                                    ' .
                                            $record->user->name . '<br>' .
                                            '<a href="mailto://' . $record->user->email . '" class="cursor-pointer hover:underline">' . $record->user->email . '</a><br>
                                            </div>
                                        </div>'
                                    )->toHtmlString();
                                }),

                            Forms\Components\Placeholder::make('alamat_pengiriman')
                                ->content(function (Pembayaran $record) {
                                    return str(
                                        '<b>' . $record->user->pelanggan->instansi . '</b><br>' .
                                            $record->user->pelanggan->telp_kantor . '<br>' .
                                            '<p class="text-gray-500">' . $record->user->pelanggan->alamat_kantor . '</p><br>'
                                    )->toHtmlString();
                                }),
                        ])->grow()->columns(),

                        Forms\Components\Section::make([

                            Forms\Components\Placeholder::make('metode')
                                ->content(fn (Pembayaran $record): string => $record->metode),
                            Forms\Components\Placeholder::make('ongkir')
                                ->content(fn (Pembayaran $record): string => 'Rp ' . number_format($record->ongkir)),
                            Forms\Components\Placeholder::make('denda')
                                ->hintIcon('heroicon-m-question-mark-circle', function (Pembayaran $record) {
                                    $persentaseDenda = \App\Models\Setting::where('key', 'persentase_denda')->first()->value;
                                    $jumlahBulan = now()->diffInMonths(date_create($record->tgl_diterima));
                                    $total = number_format($record->subtotal);

                                    return 'Jumlah Bulan Terlewat × Presentase Denda × Total Pembayaran = ' . $jumlahBulan . ' × ' . $persentaseDenda . '% × ' . $total;
                                })
                                ->content(fn (Pembayaran $record): string => 'Rp ' . number_format($record->denda)),
                            Forms\Components\Placeholder::make('total')
                                ->content(fn (Pembayaran $record): string => 'Rp ' . number_format($record->total)),
                        ])->grow()->columns(4),
                    ]),


                    Forms\Components\Section::make([
                        Forms\Components\Toggle::make('lunas')->hidden(function (Pembayaran $record) {
                            if (auth()->user()->role == 'petugas')
                                return true;

                            return $record->metode != 'tunai';
                        }),
                        Forms\Components\Toggle::make('diterima')->hidden(auth()->user()->role != 'petugas'),
                    ])
                        ->grow(false)
                        ->hidden(auth()->user()->role == 'pimpinan'),

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
                Tables\Columns\TextColumn::make('user.name')->label('Pemesan')->searchable(),
                Tables\Columns\TextColumn::make('user.pelanggan.instansi')->label('Instansi')->searchable(),
                Tables\Columns\TextColumn::make('metode')->badge()->color(fn (string $state) => $state == 'Cash' ? 'success' : 'primary'),
                Tables\Columns\TextColumn::make('subtotal')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->numeric()
                    ->prefix('Rp '),
                Tables\Columns\TextColumn::make('ongkir')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->numeric()
                    ->prefix('Rp '),
                Tables\Columns\TextColumn::make('denda')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->numeric()
                    ->prefix('Rp '),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->prefix('Rp '),
                Tables\Columns\IconColumn::make('lunas')
                    ->boolean(),
                Tables\Columns\IconColumn::make('diterima')
                    ->boolean(),
            ])
            ->searchPlaceholder('Cari Pemesan/Instansi')
            ->filters([
                Filter::make('tunai')->query(fn (Builder $query) => $query->where('metode', 'tunai')),
                Filter::make('denda')->query(fn (Builder $query) => $query->where('lunas', false) ->whereMonth('tgl_diterima', '<', now()->month)),
                TernaryFilter::make('lunas'),
                TernaryFilter::make('diterima'),
                DateRangeFilter::make('created_at')->label('Dibuat')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('cetak')
                    ->icon('heroicon-m-printer')
                    ->hidden(auth()->user()->role != 'pimpinan')
                    ->action(function (Collection $records) {
                        $recordLunas = $records->where('lunas', true);

                        return response()->streamDownload(function () use ($records, $recordLunas) {
                            echo Pdf::loadHtml(
                                Blade::render('pdf.report', [
                                    'subtitle' => 'Laporan ini dibuat pada ' . now(),
                                    'records' =>  $records,
                                    'total' => $recordLunas->sum('subtotal') + $recordLunas->sum('ongkir') + $recordLunas->sum('denda'),
                                    'cols' => [
                                        'dibuat' => 'created_at',
                                        'email' => 'user.email',
                                        'instansi' => 'user.pelanggan.instansi',
                                        'lunas' => 'lunas',
                                        'denda' => 'denda',
                                        'total' => 'total',
                                    ]
                                ])
                            )->stream();
                        }, 'Laporan pesanan ' . now() . '.pdf');
                    }),
            ])
            ->defaultSort('created_at', 'desc');
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

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->role != 'pimpinan';
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
