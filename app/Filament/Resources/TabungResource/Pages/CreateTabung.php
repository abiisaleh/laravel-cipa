<?php

namespace App\Filament\Resources\TabungResource\Pages;

use App\Filament\Resources\TabungResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTabung extends CreateRecord
{
    protected static string $resource = TabungResource::class;

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     //kodefikasi
    //     $jenis = [
    //         'oksigen' => '6',
    //         'nitrogen' => '7'
    //     ];
    //     $ukuran = [
    //         'kecil' => '200',
    //         'sedang' => '300',
    //         'besar' => '400'
    //     ];

    //     $data['kode'] = $jenis[$data['jenis']] . $ukuran[$data['ukuran']];

    //     return $data;
    // }
}
