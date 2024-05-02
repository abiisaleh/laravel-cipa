<?php

namespace App\Livewire;

use App\Livewire\Forms\PesanForm;
use App\Models\Pesanan;
use Filament\Notifications\Notification;
use Livewire\Component;

class PembayaranCreate extends Component
{
    public $items = [];
    public $total = 0;

    public PesanForm $form;

    public function mount()
    {
        $this->refreshData();
    }

    function refreshData()
    {
        $keranjang = Pesanan::where('pembayaran_id', null)->get();
        $this->items = $keranjang;
        $this->total = $keranjang->sum('subtotal');
    }

    public function save(Pesanan $pesanan)
    {
        $this->form->store($pesanan->id);
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
        return view('livewire.pembayaran-create', [
            'banks' => ['BCA', 'BNI', 'BRI', 'MANDIRI']
        ]);
    }
}
