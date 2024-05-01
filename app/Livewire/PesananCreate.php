<?php

namespace App\Livewire;

use App\Livewire\Forms\PesanForm;
use Filament\Notifications\Notification;
use Livewire\Component;

class PesananCreate extends Component
{
    public PesanForm $form;

    public function save()
    {
        $this->form->store();
        redirect(route('bayar'));
    }

    public function addToCard()
    {
        $this->form->store();

        Notification::make()
            ->icon('heroicon-s-shopping-cart')
            ->title('produk dimasukkan ke keranjang')
            ->send();
    }

    public function increment()
    {
        $this->form->qty++;
    }

    public function decrement()
    {
        $this->form->qty--;
    }

    public function render()
    {
        return view('livewire.pesanan-create');
    }
}
