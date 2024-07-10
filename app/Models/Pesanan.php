<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pesanan extends Model
{
    use HasFactory;

    protected $casts = [
        'kode_tabung' => 'array',
    ];

    public function tabung(): BelongsTo
    {
        return $this->belongsTo(Tabung::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getNamaAttribute($value)
    {
        return ucfirst($value);
    }
}
