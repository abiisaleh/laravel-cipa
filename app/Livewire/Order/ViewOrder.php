<?php

namespace App\Livewire\Order;

use App\Models\Pembayaran;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
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
        if ($this->record->metode == 'Cash')
            // dd('hahah');
            return Action::make('checkout')
                ->label('Bayar Sekarang')
                ->form([
                    Select::make('metode')
                        ->native(false)
                        ->options(
                            function () {
                                $banks = ['BCA', 'BNI', 'BRI', 'BJB', 'BSI', 'BNC', 'CIMB', 'DBS', 'Mandiri', 'Permata', 'Sahabat Sampoerna'];
                                $options = [];
                                foreach ($banks as $bank) {
                                    $options[$bank] = $bank;
                                }
                                return $options;
                            }
                        )
                ])
                ->action(function (array $data) {
                    $this->record->metode = $data['metode'];
                    $id = $this->record->id;

                    $createVA = Http::withHeader('content-type', 'application/json')
                        ->withBasicAuth(env('XENDIT_API_KEY'), '')
                        ->post('https://api.xendit.co/callback_virtual_accounts', [
                            "external_id" => "$id",
                            "bank_code" => str_replace(' ', '_', strtoupper($data['metode'])),
                            "name" => auth()->user()->name,
                            "is_single_use" => true,
                            "is_closed" => true,
                            "expected_amount" => $this->record->subtotal,
                            "expiration_date" => now()->addDay(),
                        ])->json();

                    $this->record->va_id = $createVA['id'];
                    $this->record->save();

                    return redirect(url('/checkout', $this->record->id));
                });

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
