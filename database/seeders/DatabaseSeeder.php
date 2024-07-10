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
            'name' => 'Roland Nanlohy',
            'email' => 'petugas@demo.com',
            'password' => 'demo1234',
            'role' => 'petugas'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Evan Yahya',
            'email' => 'karyawan@demo.com',
            'password' => 'demo1234',
            'role' => 'karyawan'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Sendy Pasorong',
            'email' => 'kepala@demo.com',
            'password' => 'demo1234',
            'role' => 'pimpinan'
        ]);

        $pelanggan = \App\Models\User::factory()->create([
            'name' => 'Rina Kristono',
            'email' => 'pelanggan@demo.com',
            'password' => 'demo1234',
            'role' => 'pelanggan',
        ]);

        $jenisTabung = [
            [
                'kode' => 6,
                'jenis' => 'oksigen',
            ],
            [
                'kode' => 7,
                'jenis' => 'nitrogen',
            ],

        ];

        DB::table('jenis_tabungs')->insert($jenisTabung);

        $ukuranTabung = [
            [
                'kode' => 2,
                'ukuran' => 'kecil',
                'berat' => 1,
            ],
            [
                'kode' => 3,
                'ukuran' => 'sedang',
                'berat' => 2,
            ],
            [
                'kode' => 4,
                'ukuran' => 'besar',
                'berat' => 3,
            ],
        ];

        DB::table('ukuran_tabungs')->insert($ukuranTabung);

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
            'alamat' => 'Jl. Poros',
            'kode_pos' => '99225',
            'kecamatan' => 'Abepura',
            'kelurahan' => 'Way Mhorock',
            'telp' => '6282248440010',
            'email' => 'pt.indo.gas.papua@email.com',
        ];

        foreach ($data as $key => $value) {
            DB::table('settings')->insert([
                'key' => $key,
                'value' => $value
            ]);
        }
    }
}
