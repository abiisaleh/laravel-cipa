<?php

namespace App\Filament\Resources\OngkirResource\Pages;

use App\Filament\Resources\OngkirResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageOngkirs extends ManageRecords
{
    protected static string $resource = OngkirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
