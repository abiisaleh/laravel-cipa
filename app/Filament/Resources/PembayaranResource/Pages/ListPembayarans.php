<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use App\Models\Pembayaran;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPembayarans extends ListRecords
{
    protected static string $resource = PembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $countBelumBayar = Pembayaran::where('lunas', false)->count();
        $countBelumDiantar = Pembayaran::where(fn ($query) => $query->where('metode', 'cash')->where('diterima', false))
            ->orWhere(fn ($query) => $query->whereNot('metode', 'cash')->where('lunas', true)->where('diterima', false))
            ->count();

        return [
            'semua' => Tab::make(),

            'belum_dibayar' => Tab::make()
                ->badge($countBelumBayar == 0 ? '' : $countBelumBayar)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('lunas', false)),

            'belum_diantar' => Tab::make()
                ->badge($countBelumDiantar == 0 ? '' : $countBelumDiantar)
                ->modifyQueryUsing(function (Builder $query) {
                    return $query
                        ->where(fn ($query) => $query->where('metode', 'cash')->where('diterima', false))
                        ->orWhere(fn ($query) => $query->whereNot('metode', 'cash')->where('lunas', true)->where('diterima', false));
                }),
        ];
    }
}
