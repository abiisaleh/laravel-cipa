<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            get: fn ($value) => $jenis[$this->jenis] . $ukuran[$this->ukuran],
            set: fn (string $value) => $jenis[$this->jenis] . $ukuran[$this->ukuran],
        );
    }

    public function setKodeAttribute()
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

        $this->attributes['kode'] = $jenis[$this->jenis] . $ukuran[$this->ukuran];
    }
}
