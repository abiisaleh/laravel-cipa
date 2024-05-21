<section class=" min-h-[80vh]">
    <div class="py-16 px-4 mx-auto max-w-screen-xl text-left">
        <h3 class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-4xl">
            Riwayat Pesanan
        </h3>
        <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl">Daftar tabung yang sudah dipesan. <a href="/order/new" class="text-primary-600 hover:underline">Buat pesanan baru?</a></p>
        <div class="mb-8 grid">
            <x-filament::tabs label="Content tabs">
                <x-filament::tabs.item :active="$activeTab === 'semua'"
                    wire:click="$set('activeTab', 'semua')">
                    Semua
                </x-filament::tabs.item>

                <x-filament::tabs.item :active="$activeTab
                    === 'belumBayar'"
                    wire:click="$set('activeTab', 'belumBayar')">
                    Belum dibayar
                </x-filament::tabs.item>

                <x-filament::tabs.item :active="$activeTab
                    === 'sudahBayar'"
                    wire:click="$set('activeTab', 'sudahBayar')">
                    Sudah dibayar
                </x-filament::tabs.item>

                <x-filament::tabs.item :active="$activeTab
                    === 'selesai'" wire:click="$set('activeTab', 'selesai')">
                    Selesai
                </x-filament::tabs.item>

                <x-filament::tabs.item :active="$activeTab
                    === 'batal'" wire:click="$set('activeTab', 'batal')">
                    Batal
                </x-filament::tabs.item>

            </x-filament::tabs>
        </div>

        {{ $this->table }}
    </div>
</section>
