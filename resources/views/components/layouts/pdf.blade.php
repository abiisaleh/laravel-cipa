<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <style>
        @page {
            margin-top: 200px;
        }

        .header {
            position: fixed;
            top: -150px;
        }

        table {
            width: 100%;
        }

        .table thead th {
            text-transform: uppercase;
            text-align: left;
        }

        .table tfoot {
            text-transform: uppercase;
            text-align: right;
        }

        .table tr {
            border-top: 2px solid black;
        }

        .table tr td {
            padding: 8px 0;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .bg-secondary {
            background-color: #f2f2f2;
        }

        footer {
            position: fixed;
            bottom: -25px;
            border-top: 2px solid;
            width: 100%;
            text-align: right;
        }

        .pagenum::before {
            content: counter(page);
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.4/tailwind.min.css">
</head>

<body>
    {{-- kop surat --}}
    @php

        $email = \App\Models\Setting::where('key', 'email')->first()->value ?? '';
        $telp = \App\Models\Setting::where('key', 'telp')->first()->value ?? '';
        $alamat = \App\Models\Setting::where('key', 'alamat')->first()->value ?? '';
        $kecamatan = \App\Models\Setting::where('key', 'kecamatan')->first()->value ?? '';
        $kelurahan = \App\Models\Setting::where('key', 'kelurahan')->first()->value ?? '';
        $kode_pos = \App\Models\Setting::where('key', 'kode_pos')->first()->value ?? '';

    @endphp
    <table class="header">
        <td>
            <img src="img/logo.png" alt="logo" width="40">
            <span class="text-4xl font-bold">Oxygen</span>
        </td>
        <td width="30%">
            <p> {{ $alamat }}, Kel. {{ $kelurahan }}, Kec. {{ $kecamatan }}, Kab. Kota Jayapura
                {{ $kode_pos }}</p>
            <p> {{ $email }}</p>
            <p>{{ $telp }}</p>
        </td>
    </table>

    <main>
        {{ $slot }}
    </main>

    <footer>
        <p>
            Halaman
            <span class="pagenum"></span>
        </p>
    </footer>
</body>

</html>
