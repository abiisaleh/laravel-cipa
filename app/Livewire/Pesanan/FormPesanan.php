<?php

namespace App\Livewire\Pesanan;

use App\Models\Pesanan;
use Livewire\Component;

class FormPesanan extends Component
{
    public string $jenis = '';
    public string $ukuran = '';
    public string $isi = '';
    public int $qty = 1;

    function save()
    {
        $kodeTabung = $this->jenis . $this->ukuran;

        $tabung = \App\Models\Tabung::where('kode', $kodeTabung)->firstOrFail();

        if ($this->isi == 'full')
            $harga = $tabung->harga_kosong;
        else if ($this->isi == 'refill')
            $harga = $tabung->harga_kosong;
        else
            $harga = $tabung->harga_kosong;


        Pesanan::create([
            'user_id' => auth()->id(),
            'tabung_id' => $tabung->id,
            'nama' => implode(' ', ['tabung', $tabung->jenis, $tabung->ukuran, $this->isi]),
            'harga' => $harga,
            'qty' => $this->qty
        ]);
    }

    public function addToCart()
    {
        $this->save();
        \Filament\Notifications\Notification::make()
            ->title('Pesanan berhasil ditambahkan')
            ->icon('heroicon-s-shopping-cart')
            ->send();
    }

    public function submit()
    {
        $this->save();
        redirect(url('pembayaran/new'));
    }

    public function increment()
    {
        $this->qty++;
    }

    public function decrement()
    {
        $this->qty--;
    }

    public function render()
    {
        return view('livewire.pesanan.form-pesanan');
    }
}
