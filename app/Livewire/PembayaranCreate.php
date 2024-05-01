<?php

namespace App\Livewire;

use App\Livewire\Forms\PesanForm;
use App\Models\Pesanan;
use Filament\Notifications\Notification;
use Livewire\Component;

class PembayaranCreate extends Component
{
    public $items = [];
    public $total;

    public PesanForm $form;

    public function mount()
    {
        $this->refreshData();
    }

    function refreshData()
    {
        $this->items = Pesanan::all();
        $this->total = Pesanan::all()->sum('subtotal');
    }

    public function delete(Pesanan $pesanan)
    {
        $this->form->drop($pesanan->id);

        $this->refreshData();

        Notification::make()
            ->title('berhasil dihapus')
            ->icon('heroicon-s-trash')
            ->send();
    }

    public function render()
    {
        return view('livewire.pembayaran-create');
    }
}
