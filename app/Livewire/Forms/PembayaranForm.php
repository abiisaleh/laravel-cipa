<?php

namespace App\Livewire\Forms;

use App\Models\Pembayaran;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PembayaranForm extends Form
{
    public function store()
    {
        $this->validate();

        Pembayaran::create([]);
    }
}
