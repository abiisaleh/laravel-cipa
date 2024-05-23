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

            $diterima = fake()->boolean();
            $lunas = false;

            if ($diterima)
                $lunas = fake()->boolean();

            $pembayaran = Pembayaran::factory()
                ->create([
                    'subtotal' => $pesanan->harga * $pesanan->qty,
                    'ongkir' => $pesanan->tabung->berat * 10000,
                    'lunas' => $lunas,
                    'tgl_lunas' => $lunas ? $date->add(new DateInterval('PT1H')) : null,
                    'diterima' => $diterima,
                    'tgl_diterima' => $diterima ? $date->add(new DateInterval('P2D')) : null,
                    'created_at' => $date
                ]);

            $pesanan->pembayaran_id = $pembayaran->id;
            $pesanan->save();
        }
    }
}
