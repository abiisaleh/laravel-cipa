<?php

namespace App\Livewire\Checkout;

use App\Models\Pembayaran;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ViewCheckout extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public Pembayaran $record;
    public $date;
    public $va = null;
    protected $view;

    public function mount()
    {
        if ($this->record->lunas)
            return redirect(url('checkout/' . $this->record->id . '/print'));

        $this->date = Carbon::parse($this->record->created_at)->addDays(30);

        if ($this->record->metode != 'Cash') {
            $this->va = Http::withHeader('content-type', 'application/json')
                ->withBasicAuth(env('XENDIT_API_KEY'), '')
                ->get('https://api.xendit.co/callback_virtual_accounts/' . $this->record->va_id)->json();

            $this->date = Carbon::parse($this->va["expiration_date"]);
        }
    }

    public function simulateAction(): Action
    {
        return Action::make('simulate')
            ->label('💳 Bayar sekarang.')
            ->link()
            ->action(function () {
                $createVA = Http::withHeader('content-type', 'application/json')
                    ->withBasicAuth(env('XENDIT_API_KEY'), '')
                    ->post('https://api.xendit.co/callback_virtual_accounts/external_id=' . $this->record->id . '/simulate_payment', [
                        "amount" => $this->record->subtotal,
                    ])->json();
                $this->record->va_id = $createVA['id'];
                $this->record->save();

                sleep(10);

                return redirect(url('checkout/' . $this->record->id . '/print'));
            });
    }

    public function render()
    {
        return view('livewire.checkout.view-checkout');
    }
}
