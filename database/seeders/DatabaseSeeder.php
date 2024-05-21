<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Petugas Gudang',
            'email' => 'petugas@demo.com',
            'password' => 'demo1234',
            'role' => 'petugas'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Karyawan',
            'email' => 'karyawan@demo.com',
            'password' => 'demo1234',
            'role' => 'karyawan'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Kepala Pimpinan',
            'email' => 'kepala@demo.com',
            'password' => 'demo1234',
            'role' => 'pimpinan'
        ]);

        $pelanggan = \App\Models\User::factory()->create([
            'name' => 'Pelanggan',
            'email' => 'pelanggan@demo.com',
            'password' => 'demo1234',
            'role' => 'pelanggan',
        ]);

        $jenis = ['oksigen', 'nitrogen'];
        $tabung = [
            'kecil' => [350000, 200000, 150000],
            'sedang' => [500000, 250000, 250000],
            'besar' => [750000, 350000, 400000]
        ];

        foreach ($jenis as $Jenis) {
            foreach ($tabung as $ukuran => $harga) {
                //kodefikasi
                $kode_jenis = [
                    'oksigen' => '6',
                    'nitrogen' => '7'
                ];
                $kode_ukuran = [
                    'kecil' => '200',
                    'sedang' => '300',
                    'besar' => '400'
                ];

                $data[] = [
                    'kode' => $kode_jenis[$Jenis] . $kode_ukuran[$ukuran],
                    'jenis' => $Jenis,
                    'ukuran' => $ukuran,
                    'stok' => 100,
                    'harga_full' => $harga[0],
                    'harga_refill' => $harga[1],
                    'harga_kosong' => $harga[2]
                ];
            }
        }

        DB::table('tabungs')->insert($data);

        DB::table('pelanggans')->insert([
            'user_id' => $pelanggan->id,
            'instansi' => 'RSUD Abepura',
            'email_kantor' => 'simrs.abe@gmail.com',
            'alamat_kantor' => 'Jl. Kesehatan No.1, Yobe, Kec. Abepura, Kota Jayapura, Papua 99351',
            'telp_kantor' => '0967581064',
            'verified' => true,
        ]);

        $data = [
            'ongkir' => 10000,
            'persentase_denda' => 5,
            'alamat' => '',
            'kode_pos' => '99351',
            'kecamatan' => '',
            'kelurahan' => '',
            'telp' => '',
            'email' => '',
        ];

        foreach ($data as $key => $value) {
            DB::table('settings')->insert([
                'key' => $key,
                'value' => $value
            ]);
        }

        $tabung = DB::table('tabungs')->inRandomOrder()->first();
        $qty = rand(1, 10);

        DB::table('pembayarans')->insert([
            'metode' => 'cash',
            'subtotal' => $qty * $tabung->harga_refill,
            'ongkir' => $tabung->berat * 10000,
            'created_at' => now(),
        ]);

        DB::table('pesanans')->insert([
            'tabung_id' => $tabung->id,
            'user_id' =>  $pelanggan->id,
            'pembayaran_id' =>  1,
            'nama' => 'tabung ' . $tabung->jenis . ' ' . $tabung->ukuran . ' refill',
            'harga' => $tabung->harga_refill,
            'qty' => $qty,
            'created_at' => now()->subHour(),
        ]);
    }
}
