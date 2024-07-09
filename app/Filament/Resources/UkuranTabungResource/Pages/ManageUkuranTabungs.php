<?php

namespace App\Filament\Resources\UkuranTabungResource\Pages;

use App\Filament\Resources\UkuranTabungResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUkuranTabungs extends ManageRecords
{
    protected static string $resource = UkuranTabungResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
