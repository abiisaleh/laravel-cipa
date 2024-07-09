<?php

namespace App\Filament\Resources\JenisTabungResource\Pages;

use App\Filament\Resources\JenisTabungResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageJenisTabungs extends ManageRecords
{
    protected static string $resource = JenisTabungResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
