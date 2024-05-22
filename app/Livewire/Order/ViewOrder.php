<?php

namespace App\Livewire\Order;

use App\Models\Pembayaran;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;

class ViewOrder extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public int $id;
    public $record;
    public $items;

    public function mount()
    {
        $this->record = Pembayaran::withTrashed()->find($this->id);

        $this->items = $this->record->pesanan;
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->requiresConfirmation()
            ->outlined()
            ->color('danger')
            ->label('Batalkan Pesanan')
            ->action(function () {
                //kembalikan stok tiap pesanan
                foreach ($this->items as $pesanan) {
                    //cek stok selain refill
                    if (!strpos($pesanan->nama, 'refill')) {
                        $tabung = \App\Models\Tabung::find($pesanan->tabung->id);
                        $tabung->stok += $pesanan->qty;
                        $tabung->save();
                    }
                }

                $this->record->delete();

                Notification::make()
                    ->title('Pesanan dibatalkan')
                    ->icon('heroicon-s-trash')
                    ->iconColor('danger')
                    ->send();
            });
    }

    public function restoreAction(): Action
    {

        return Action::make('restore')
            ->requiresConfirmation()
            ->label('Pesan Lagi')
            ->action(function () {
                $this->record->restore();

                Notification::make()
                    ->title('Pesanan dibuat ulang')
                    ->success()
                    ->send();
            });
    }

    public function checkoutAction(): Action
    {

        return Action::make('checkout')
            ->label('Bayar Sekarang')
            ->url(
                url('checkout', $this->record->id)
            );
    }

    public function render()
    {
        return view('livewire.order.view-order');
    }
}
