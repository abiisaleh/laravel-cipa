@php
    $active = $theme ?? 0;
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

    <footer>
        <div class="w-full max-w-screen-xl mx-auto p-4">
            <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
            <span class="block text-sm {{ $active ? 'text-white' : 'text-gray-500' }} text-center ">© 2024 made by <a
                    href="https://abiisaleh.xyz/" class="hover:underline">abiisaleh</a> with ❤️</span>
        </div>
    </footer>

    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>
