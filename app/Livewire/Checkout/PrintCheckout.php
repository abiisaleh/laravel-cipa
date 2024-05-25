<?php

namespace App\Livewire\Checkout;

use App\Models\Pembayaran;
use Livewire\Component;

class PrintCheckout extends Component
{
    public Pembayaran $record;

    public function render()
    {
        return view('livewire.checkout.print-checkout')->layout('components.layouts.app', ['theme' => 1]);
    }
}
