<?php

namespace App\Livewire\Pembayaran;

use App\Models\Pembayaran;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class FormPembayaran extends Component
{
    public int $total = 0;

    public function mount()
    {
        $this->total = \App\Models\Pesanan::where('pembayaran_id', null)->get()->sum('subtotal');
    }

    public function save()
    {
        $this->validate();

        $pembayaran = Pembayaran::create([]);

        $createVA = Http::withHeader('content-type', 'application/json')
            ->withBasicAuth(env('XENDIT_API_KEY'), '')
            ->post('https://api.xendit.co/callback_virtual_accounts')
            ->body([
                "external_id" => $pembayaran->id,
                "bank_code" => "BNI",
                "name" => $pembayaran->user->name,
                "is_single_use" => true,
                "is_closed" => true,
                "expected_amount" => $pembayaran->total,
                "expiration_date" => now()->addHours(3),
            ]);

        $pembayaran->va_id = $createVA['id'];
        $pembayaran->save();

        // $getVA = Http::withHeader('content-type', 'application/json')
        //     ->withBasicAuth(env('XENDIT_API_KEY'), '')
        //     ->get('https://api.xendit.co/callback_virtual_accounts/' . ':id');
    }

    public function render()
    {
        return view('livewire.pembayaran.form-pembayaran');
    }
}
