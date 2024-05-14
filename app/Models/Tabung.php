<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tabung extends Model
{
    use HasFactory;

    protected function kode(): Attribute
    {
        $jenis = [
            'oksigen' => '6',
            'nitrogen' => '7'
        ];
        $ukuran = [
            'kecil' => '200',
            'sedang' => '300',
            'besar' => '400'
        ];

        return Attribute::make(
            get: fn () => $jenis[$this->jenis] . $ukuran[$this->ukuran],
            set: fn () => $jenis[$this->jenis] . $ukuran[$this->ukuran],
        );
    }

    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }
}
