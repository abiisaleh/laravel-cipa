<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HargaTabung extends Model
{
    use HasFactory;

    protected function nama(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->jenisTabung->jenis} {$this->ukuranTabung->ukuran}"
        );
    }

    protected function stok(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tabung()->where('active', true)->where('digunakan', false)->count()
        );
    }

    public function jenisTabung(): BelongsTo
    {
        return $this->belongsTo(JenisTabung::class);
    }

    public function ukuranTabung(): BelongsTo
    {
        return $this->belongsTo(UkuranTabung::class);
    }

    public function tabung(): HasMany
    {
        return $this->hasMany(Tabung::class);
    }
}
