<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
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
        return [
            'semua' => Tab::make(),
            'belum_dibayar' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('lunas', false)),
            'belum_diantar' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('lunas', true)->where('diterima', true)),
        ];
    }
}
