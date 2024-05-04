<x-layouts.app>
    <section class=" min-h-[80vh]">
        <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 min-h-[80vh]">
            <div class="order-2 md:order-1 mr-auto place-self-center text-center md:text-left lg:col-span-7 mx-auto">
                <p class="max-w-2xl mb-2 font-semibold lg:mb-4 md:text-lg lg:text-xl">
                    <span class="animate-wave inline-block transform origin-bottom-right">👋</span> Hi! Selamat datang,
                </p>
                <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl">
                    Butuh Tabung <br>
                    Oksigen & Nitrogen? </h1>
                <p class="max-w-2xl mb-6 text-gray-500 lg:mb-8 md:text-lg lg:text-xl">
                    Yuk, pesan sekarang di website kami! Cepat, gampang, dan bisa diandalkan.</p>
                <div class="md:flex">
                    <a href="{{ filament()->getRegistrationUrl() }}"
                        class="w-full md:w-auto shadow-lg hover:shadow-none inline-flex items-center justify-center px-6 py-3 mr-3 text-base font-medium text-center text-white rounded-full bg-primary-600 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300">
                        Ayo gabung!
                        @svg('heroicon-s-arrow-right', ['class' => 'w-5 h-5 ml-2 -mr-1'])
                    </a>
                    <a href="{{ url('order/new') }}"
                        class=" block mt-2 w-full md:w-auto md:mt-0 md:inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-full hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        Masuk
                    </a>
                </div>

            </div>
            <div class=" w-60 md:w-full order-1 md:order-2 place-self-center lg:mt-0 lg:col-span-5 lg:block">
                <img src="/img/tube.webp" alt="test tube">
            </div>
        </div>

        <div class="absolute top-0 right-0 -z-10 w-96 h-96 md:w-[90vh] md:h-[90vh] bg-primary-100 rounded-bl-full">
        </div>
    </section>
</x-layouts.app>
