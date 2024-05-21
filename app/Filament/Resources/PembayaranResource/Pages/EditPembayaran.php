<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPembayaran extends EditRecord
{
    protected static string $resource = PembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {

        if (!$this->record->lunas & $data['lunas']) {
            $this->record->tgl_lunas = now();
            $this->record->save();
        }

        if ($this->record->lunas & !$data['lunas']) {
            $this->record->tgl_lunas = null;
            $this->record->save();
        }

        if (!$this->record->diterima & $data['diterima']) {
            $this->record->tgl_diterima = now();
            $this->record->save();
        }

        if ($this->record->diterima & !$data['diterima']) {
            $this->record->tgl_diterima = null;
            $this->record->save();
        }

        return $data;
    }
}
