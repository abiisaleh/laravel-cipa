<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use App\Models\Pembayaran;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPembayaran extends EditRecord
{
    protected static string $resource = PembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function (Pembayaran $record) {
                    //kembalikan stok tiap pesanan
                    foreach ($record->pesanan as $pesanan) {
                        //cek stok selain refill
                        if (!strpos($pesanan->nama, 'refill')) {
                            $tabung = \App\Models\Tabung::find($pesanan->tabung->id);
                            $tabung->stok += $pesanan->qty;
                            $tabung->save();
                        }
                    }
                }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (auth()->user()->role == 'karyawan') {
            if (!$this->record->lunas & $data['lunas']) {
                $this->record->tgl_lunas = now();
                $this->record->save();

                // kirim notifikasi ke user
                Notification::make()
                    ->title('Pembayaran berhasil')
                    ->body('Pesanan #' . $this->record->id . ' dengan total Rp. ' . number_format($this->record->total) . ' telah berhasil di bayar.')
                    ->actions(
                        [
                            Action::make('lihat')->url('/order/' . $this->record->id)
                        ]
                    )
                    ->sendToDatabase($this->record->user);
            }

            if ($this->record->lunas & !$data['lunas']) {
                $this->record->tgl_lunas = null;
                $this->record->save();
            }
        }

        if (auth()->user()->role == 'petugas') {
            if (!$this->record->diterima & $data['diterima']) {
                $this->record->tgl_diterima = now();
                $this->record->save();

                // kirim notifikasi ke user
                Notification::make()
                    ->title('Pesanan tiba')
                    ->body('Pesanan #' . $this->record->id . ' telah sampai ditujuan.')
                    ->actions(
                        [
                            Action::make('lihat')->url('/order/' . $this->record->id)
                        ]
                    )
                    ->sendToDatabase($this->record->user);
            }

            if ($this->record->diterima & !$data['diterima']) {
                $this->record->tgl_diterima = null;
                $this->record->save();
            }
        }

        return $data;
    }
}
