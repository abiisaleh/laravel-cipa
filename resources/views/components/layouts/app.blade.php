<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">


    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <header>
        <nav class="bg-primary-500 border-gray-200 px-4 lg:px-6 py-4">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                <a href="{{ config('app.url') }}" class="flex items-center">
                    <span
                        class="self-center text-xl font-semibold whitespace-nowrap text-white">{{ config('app.name') }}</span>
                </a>
                <div class="flex items-center lg:order-2">
                    <x-navbar />
                </div>
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    @livewire('notifications')

    <footer class="bg-white">
        <div class="w-full max-w-screen-xl mx-auto p-4">
            <hr class="my-6 border-gray-200 sm:mx-auto  lg:my-8" />
            <span class="block text-sm text-gray-500 text-center ">© 2023 <a href="https://abiisaleh.xyz/"
                    class="hover:underline">abiisaleh</a>. All Rights Reserved.</span>
        </div>
    </footer>

    @filamentScripts
</body>

</html>
