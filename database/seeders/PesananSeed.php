<?php

namespace Database\Seeders;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use App\Models\Tabung;
use App\Models\User;
use DateInterval;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesananSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $date = fake()->dateTimeBetween('-3 months', 'yesterday');

            $pesanan = Pesanan::factory()
                ->for(Tabung::all()->random())
                ->for(User::where('role', 'pelanggan')->get()->random())
                ->create([
                    'created_at' => $date->sub(new DateInterval('PT3H'))
                ]);

            $pembayaran = Pembayaran::factory()
                ->create([
                    'subtotal' => $pesanan->harga * $pesanan->qty,
                    'ongkir' => $pesanan->tabung->berat * 10000,
                    'lunas' => true,
                    'tgl_lunas' => $date->add(new DateInterval('PT1H')),
                    'diterima' => true,
                    'tgl_diterima' => $date->add(new DateInterval('P2D')),
                    'created_at' => $date
                ]);

            $pesanan->pembayaran_id = $pembayaran->id;
            $pesanan->save();
        }
    }
}
