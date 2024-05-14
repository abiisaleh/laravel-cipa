<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->pesanan->first()->user->email
        );
    }

    protected function instansi(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->pesanan->first()->user->pelanggan->instansi
        );
    }

    protected function denda(): Attribute
    {
        $persentaseDenda = Setting::where('key', 'persentase_denda')->first()->value;
        $jumlahBulan = now()->diffInMonths(date_create($this->created_at));

        return Attribute::make(
            get: fn () => $this->subtotal * $persentaseDenda * $jumlahBulan
        );
    }

    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->subtotal + $this->ongkir + $this->denda
        );
    }
}
