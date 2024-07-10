<?php

namespace App\Filament\Resources\TabungResource\Pages;

use App\Filament\Resources\TabungResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTabung extends EditRecord
{
    protected static string $resource = TabungResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
