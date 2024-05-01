<?php

namespace App\Livewire\Forms;

use App\Models\Pesanan;
use App\Models\Tabung;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PesanForm extends Form
{
    #[\Livewire\Attributes\Rule(['required'])]
    public string $jenis = '';

    #[\Livewire\Attributes\Rule(['required'])]
    public string $ukuran = '';

    #[\Livewire\Attributes\Rule(['required'])]
    public string $isi = '';

    #[\Livewire\Attributes\Rule(['required'])]
    public int $qty = 0;

    public function store()
    {
        $kodeTabung = $this->jenis . $this->ukuran;
        $isiTabung = $this->isi;

        $tabung = Tabung::where('kode', $kodeTabung)->firstOrFail();

        if ($isiTabung == 'full')
            $harga = $tabung->harga_kosong;
        else if ($isiTabung == 'refill')
            $harga = $tabung->harga_kosong;
        else
            $harga = $tabung->harga_kosong;

        $this->validate();

        Pesanan::create([
            'user_id' => auth()->id(),
            'tabung_id' => $tabung->id,
            'nama' => implode(' ', ['tabung', $tabung->jenis, $tabung->ukuran, $this->isi]),
            'harga' => $harga,
            'qty' => $this->qty
        ]);
    }

    public function drop($id)
    {
        Pesanan::find($id)->delete();
    }
}
