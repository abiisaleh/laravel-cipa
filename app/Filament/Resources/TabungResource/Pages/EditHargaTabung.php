<?php

namespace App\Filament\Resources\TabungResource\Pages;

use App\Filament\Resources\TabungResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTabung extends EditRecord
{
    protected static string $resource = TabungResource::class;

    protected function getFormActions(): array
    {
        if (auth()->user()->role == 'karyawan')
            return [
                $this->getSaveFormAction(),
                $this->getCancelFormAction(),
            ];

        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
