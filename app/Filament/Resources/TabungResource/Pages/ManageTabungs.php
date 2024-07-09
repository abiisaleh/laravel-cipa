<?php

namespace App\Filament\Resources\TabungResource\Pages;

use App\Filament\Resources\TabungResource;
use App\Filament\Resources\TabungResource\Widgets\TabungOverview;
use App\Models\HargaTabung;
use App\Models\Tabung;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;

class ManageTabungs extends ManageRecords
{
    protected static string $resource = TabungResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            TabungOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $hargaId = $data['harga_tabung_id'];
                    $tabung = [];
                    for ($i = 0; $i < $data['jumlah']; $i++) {
                        $tabung[] = [
                            'harga_tabung_id' => $hargaId,
                            'kode' => HargaTabung::find($hargaId)->kode . str_pad((Tabung::where('harga_tabung_id', $hargaId)->count() + 1 + $i), 2, '0', STR_PAD_LEFT)
                        ];
                    }

                    return $tabung;
                })->using(function (array $data, string $model): Model {
                    $model::insert($data);
                    return $model::latest()->first();
                }),
        ];
    }
}
