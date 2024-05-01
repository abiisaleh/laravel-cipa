<x-layouts.app>
    <section class="bg-white min-h-[80vh]">
        <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 h-[80vh]">
            <div class="mr-auto place-self-center text-center md:text-left lg:col-span-7">
                <h1
                    class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">
                    Sistem Informasi <br>Pemesanan<span class="text-primary-600"> Tabung Oksigen & Nitrogen</span></h1>
                <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">From
                    checkout to global sales tax compliance, companies around the world use Flowbite to simplify their
                    payment stack.</p>
                <a href="{{ filament()->getRegistrationUrl() }}"
                    class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-primary-600 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                    Buat akun
                    @svg('heroicon-s-arrow-right', ['class' => 'w-5 h-5 ml-2 -mr-1'])
                </a>
                <a href="{{ url('pesan') }}"
                    class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                    Masuk
                </a>
            </div>
            <div class="hidden place-self-center lg:mt-0 lg:col-span-5 lg:block">
                <img src="/img/oxygen.png" alt="mockup">
            </div>
        </div>
    </section>
</x-layouts.app>
