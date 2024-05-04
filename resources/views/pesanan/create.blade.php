<x-layouts.app>
    <section class="bg-white">
        <div class="py-16 px-4 mx-auto max-w-screen-xl text-left">
            <h3 class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-4xl">
                Pesan
                tabung</h3>
            <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl">Pilih tabung yang ingin dipesan.</p>
            <div class="flex gap-4 ">
                <div class="w-full">
                    <livewire:pesanan.form-pesanan />
                </div>

                <div class="w-full">
                    <div class="bg-gray-50 rounded p-4">
                        <livewire:pesanan.list-pesanan :$items />

                        <livewire:pembayaran.form-pembayaran />
                    </div>
                </div>
            </div>

        </div>
    </section>
</x-layouts.app>
