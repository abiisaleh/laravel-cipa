<section class=" min-h-[80vh]">
    <div class="py-16 px-4 mx-auto max-w-screen-xl text-left">
        <div class="sm:flex sm:items-center justify-between mb-8">
            <div class="">
                <h3 class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-4xl">
                    Riwayat Pesanan
                </h3>
                <p class=" text-lg font-normal text-gray-500 lg:text-xl">Daftar tabung yang sudah dipesan.</p>
            </div>
            
            <a href="/order/new" class="mt-2 items-center inline-flex text-center bg-primary-600 px-4 py-2 rounded text-white hover:bg-primary-800 focus:ring-4 focus:ring-primary-300">
                @svg('heroicon-s-shopping-cart', 'w-6, h-6 me-2')
                Buat pesanan
            </a>
        </div>
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
                    @if ($countBelumBayar != 0)
                        <span class="bg-primary-200 text-primary-600 rounded px-1.5">{{$countBelumBayar}}</span>
                    @endif
                </x-filament::tabs.item>

                <x-filament::tabs.item :active="$activeTab
                    === 'sudahBayar'"
                    wire:click="$set('activeTab', 'sudahBayar')">
                    Sudah dibayar 
                    @if ($countSudahBayar != 0)
                        <span class="bg-primary-200 text-primary-600 rounded px-1.5">{{$countSudahBayar}}</span>
                    @endif
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
