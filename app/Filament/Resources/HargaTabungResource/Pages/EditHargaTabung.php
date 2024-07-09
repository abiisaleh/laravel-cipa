<?php

namespace App\Filament\Resources\HargaTabungResource\Pages;

use App\Filament\Resources\HargaTabungResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHargaTabung extends EditRecord
{
    protected static string $resource = HargaTabungResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
