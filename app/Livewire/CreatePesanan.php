<?php

namespace App\Livewire;

use App\Models\Pesanan;
use Livewire\Component;

class CreatePesanan extends Component
{
    public $items = [];
    public string $jenis = '';
    public string $ukuran = '';
    public string $isi = '';

    public array $tabung = [];
    public int $berat = 0;
    public int $harga = 0;
    public int $qty = 1;

    public int $subtotal = 0;
    public int $ongkir = 0;

    public function mount()
    {
        $this->items = Pesanan::all();
        $this->subtotal = Pesanan::all()->sum('subtotal');
    }

    public function cekTabung()
    {
        $this->tabung = \App\Models\Tabung::where('jenis', $this->jenis)
            ->where('ukuran', $this->ukuran)
            ->firstOrFail()
            ->attributesToArray();
    }

    public function cekHarga($isi)
    {
        $this->isi = $isi;
        $this->harga;
    }

    public function increment()
    {
        $this->qty++;
    }

    public function decrement()
    {
        $this->qty--;
    }

    public function addToCart()
    {
        $tabung = \App\Models\Tabung::where('jenis', $this->jenis)
            ->where('ukuran', $this->ukuran)
            ->firstOrFail();

        $namaTabung = implode(' ', [
            'tabung',
            $tabung->jenis,
            $tabung->ukuran,
            $this->isi
        ]);

        $pesanan = Pesanan::where('nama', $namaTabung)
            ->where('pembayaran_id', null)
            ->first();

        if ($pesanan === null) {
            Pesanan::create([
                'user_id' => auth()->id(),
                'tabung_id' => $tabung->id,
                'nama' => $namaTabung,
                'harga' => $this->harga,
                'qty' => $this->qty
            ]);
        } else {
            $pesanan->qty += $this->qty;
            $pesanan->save();
        }

        \Filament\Notifications\Notification::make()
            ->title('Item ditambahkan')
            ->icon('heroicon-s-shopping-cart')
            ->iconColor('info')
            ->send();

        $this->mount();
    }

    public function delete(Pesanan $record)
    {
        $record->delete();

        $this->mount();

        \Filament\Notifications\Notification::make()
            ->title('Item dihapus')
            ->icon('heroicon-s-trash')
            ->iconColor('danger')
            ->send();
    }

    public function render()
    {
        return view('livewire.create-pesanan');
    }
}
