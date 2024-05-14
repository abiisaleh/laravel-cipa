<?php

namespace App\Livewire\Order;

use App\Models\Pesanan;
use Livewire\Component;

class CreateOrder extends Component
{
    public $items = [];
    public string $jenis = '';
    public string $ukuran = '';
    public string $isi = '';

    public array $tabung = [];
    public array $berat = [];
    public int $harga = 0;
    public int $qty = 1;
    public int $stok = 0;

    public int $subtotal = 0;
    public int $ongkir;

    public int $countItems = 0;

    public function mount()
    {
        $this->items = \App\Models\Pesanan::with('tabung')
            ->whereNull('pembayaran_id')
            ->where('user_id', auth()->id())
            ->get();

        $this->countItems = Pesanan::with('tabung')
            ->whereNull('pembayaran_id')
            ->where('user_id', auth()->id())->count();

        $hargaOngkir = \App\Models\Setting::where('key', 'ongkir')->first()->value;

        $this->ongkir = 0;

        $this->items->each(function ($item) use (&$hargaOngkir) {
            $this->ongkir += $item->tabung->berat * $hargaOngkir * $item->qty;
        });

        $this->subtotal = $this->items->sum('subtotal');
    }

    public function cekTabung()
    {
        $tabung = \App\Models\Tabung::where('jenis', $this->jenis)
            ->get()
            ->each(function ($item) {
                $this->berat[$item->ukuran] = $item->berat;
            });
    }

    public function cekUkuran()
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
        $this->stok = $this->tabung['stok'];
    }

    public function increment()
    {
        if ($this->stok > $this->qty)
            $this->qty++;
    }

    public function decrement()
    {
        if ($this->qty > 0)
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

        $pesanan = \App\Models\Pesanan::where('nama', $namaTabung)
            ->where('pembayaran_id', null)
            ->first();

        //cek stok pesanan selain refill
        if ($this->isi != 'refill')
            if ($tabung->stok < $this->qty) {
                // kalau ada stok yang kurang tampilkan error
                return \Filament\Notifications\Notification::make()
                    ->title('Stok tidak cukup')
                    ->body('sisa tabung tersedia ' . $tabung->stok)
                    ->danger()
                    ->send();
            }

        if ($pesanan === null) {
            \App\Models\Pesanan::create([
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

    public function delete(\App\Models\Pesanan $record)
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
        return view('livewire.order.create-order');
    }
}
