@php
    $active = $theme ?? 0;

    $email = \App\Models\Setting::where('key', 'email')->first()->value ?? '';
    $telp = \App\Models\Setting::where('key', 'telp')->first()->value ?? '';
    $alamat = \App\Models\Setting::where('key', 'alamat')->first()->value ?? '';
    $kecamatan = \App\Models\Setting::where('key', 'kecamatan')->first()->value ?? '';
    $kelurahan = \App\Models\Setting::where('key', 'kelurahan')->first()->value ?? '';
    $kode_pos = \App\Models\Setting::where('key', 'kode_pos')->first()->value ?? '';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @filamentStyles
    @vite('resources/css/app.css')
</head>

<body class="antialiased {{ $active ? 'bg-primary-500' : '' }}">

    <x-navbar />

    <main>
        {{ $slot }}
    </main>

    @livewire('notifications')

    @if (auth()->check())
        @livewire('database-notifications')
    @endif

    <footer class="p-4 sm:p-6 ">
        <div class="mx-auto max-w-screen-xl">
            <div class="md:flex md:justify-between">
                <div class="mb-6 md:mb-0">
                    <a href="/" class="flex items-center">
                        <img src="/img/logo.png" class="mr-3 h-8" alt="Oxygen Logo" />
                        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Oxygen</span>
                    </a>
                </div>
                <div class="text-right text-sm text-gray-500">
                    <p>{{ $alamat }}, Kel. {{ $kelurahan }}, Kec. {{ $kecamatan }},<br> Kab. Kota Jayapura
                        {{ $kode_pos }}</p>
                    <p>
                        <a href="mailto://{{ $email }}"
                            class=" text-primary-600 underline">{{ $email }}</a> |
                        <span class="font-semibold">{{ $telp }}</span>
                    </p>
                </div>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
            <p class="text-sm text-gray-500 text-center dark:text-gray-400">© 2024 made by <a
                    href="https://abiisaleh.xyz" class="hover:underline">abiisaleh</a>.
            </p>
        </div>
    </footer>


    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>
