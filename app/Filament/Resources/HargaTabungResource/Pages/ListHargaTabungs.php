<?php

namespace App\Filament\Resources\HargaTabungResource\Pages;

use App\Filament\Resources\HargaTabungResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHargaTabungs extends ListRecords
{
    protected static string $resource = HargaTabungResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
