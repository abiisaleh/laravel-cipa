<?php

namespace App\Livewire;

use App\Models\Pembayaran;
use Livewire\Component;

class ViewOrder extends Component
{
    public ?Pembayaran $record;

    public $items;

    public function mount()
    {
        $this->items = $this->record->pesanan;
    }

    public function render()
    {
        return view('livewire.view-order');
    }
}
