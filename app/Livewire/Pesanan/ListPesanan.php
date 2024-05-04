<?php

namespace App\Livewire\Pesanan;

use App\Models\Pesanan;
use Livewire\Component;

class ListPesanan extends Component
{
    public $items = [];

    public function delete(Pesanan $record)
    {
        $record->delete();

        $this->items = Pesanan::all();

        \Filament\Notifications\Notification::make()
            ->title('berhasil dihapus')
            ->icon('heroicon-s-trash')
            ->send();
    }

    public function render()
    {
        return view('livewire.pesanan.list-pesanan');
    }
}
