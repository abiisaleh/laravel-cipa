<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function denda(): Attribute
    {
        if ($this->tgl_diterima) {
            $persentaseDenda = Setting::where('key', 'persentase_denda')->first()->value / 100;
            $jumlahBulan = now()->diffInMonths(date_create($this->tgl_diterima));

            return Attribute::make(
                get: fn () => $this->subtotal * $persentaseDenda * $jumlahBulan
            );
        }

        return Attribute::make(
            get: fn () => 0
        );
    }

    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->subtotal + $this->ongkir + $this->denda
        );
    }
}
