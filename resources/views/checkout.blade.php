<x-layouts.app theme="1">
    <section>
        <div class="py-12 px-4 mx-auto max-w-screen-xl text-left min-h-[78vh]">
            <div class="relative md:w-1/2 mx-auto shadow-lg bg-white rounded border-b">
                <div
                    class="absolute -top-10 left-1/2 -translate-x-1/2 bg-success-400 text-white rounded-full p-4 inline-block border-8 border-white">
                    @svg('heroicon-s-check', 'w-9 h-9')
                </div>

                <div class="absolute top-40 -left-3 bg-primary-500 rounded-full inline-block w-6 h-6"></div>
                <div class="absolute top-40 -right-3 bg-primary-500 rounded-full inline-block w-6 h-6"></div>

                <div class="flex justify-center items-end text-center pt-16">
                    <p>Rp</p>
                    <h3 class="text-4xl font-semibold">500.000</h3>

                </div>

                <p class="text-center text-gray-600 py-4 mb-2.5">Berhasil</p>

                <hr class="border-dashed border-2">

                <x-list key='Total Pembayaran' value='Rp 1239.000' />
                <x-list key='Metode Pembayaran' value='Rp 1239.000' />
                <x-list key='Total Pembayaran' value='Rp 1239.000' />
                <x-list key='Total Pembayaran' value='Rp 1239.000' />
                <x-list key='Total Pembayaran' value='Rp 1239.000' />


                <div class="flex">
                    <button
                        class="mx-4 py-2 px-4 bg-primary-600 rounded hover:bg-primary-800 w-full mt-8 mb-4 text-white">Download
                        Nota</button>
                </div>

            </div>
        </div>
    </section>
</x-layouts.app>
