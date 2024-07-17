<?php

namespace Database\Seeders;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use App\Models\Setting;
use App\Models\Tabung;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesananDendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tabung = Tabung::all()->random();
        $qty = rand(1, 5);
        $pesanan = DB::table('pesanans')
            ->insert([
                'tabung_id' => $tabung->id,
                'tabung' => $tabung->nama,
                'kode_tabung' => $tabung->kode,
                'harga' => $tabung->harga_full,
                'qty' => $qty,
            ]);

        $ongkir = Setting::where('key', 'ongkir')->first()->value;
        $pembayaran = Pembayaran::factory()
            ->create([
                'user_id' => User::where('role', 'pelanggan')->first()->id,
                'subtotal' => $tabung->harga_full * $qty,
                'ongkir' => $tabung->berat * $ongkir,
                'lunas' => false,
                'metode' => 'tunai',
                'diterima' => true,
                'tgl_diterima' => now()->subMonth(),
                'created_at' => now()->subMonth()->subDays(2)
            ]);

        $lastPesanan = Pesanan::all()->count();
        Pesanan::find($lastPesanan)->update(['pembayaran_id' => $pembayaran->id]);
    }
}
