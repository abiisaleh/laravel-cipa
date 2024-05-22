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

            $subtotal = 0;
            $berat = 0;

            foreach ($pesanan as $record) {
                $subtotal += $record->harga * $record->qty;
                $berat += $record->tabung->berat;
            }

            $pembayaran = Pembayaran::factory()
                ->create([
                    'subtotal' => $subtotal,
                    'ongkir' => $berat * 10000,
                    'lunas' => true,
                    'tgl_lunas' => $date->add(new DateInterval('PT1H')),
                    'diterima' => true,
                    'tgl_diterima' => $date->add(new DateInterval('P2D')),
                    'created_at' => $date
                ]);

            foreach ($pesanan as $record) {
                $record->pembayaran_id = $pembayaran->id;
                $record->save();
            }
        }
    }
}
