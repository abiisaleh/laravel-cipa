<div class="border-gray-100 border-2 rounded-md shadow-sm mb-4">
    <div class="flex items-center p-4" x-on:click="open = !open">
        <div class="flex justify-between w-full">
            <div class="flex w-full">
                <h1
                    class="hidden md:block text-xl p-4 font-bold bg-primary-600 text-white rounded-md me-4 w-20 text-center ">
                    @if (strpos($pesanan->nama, 'oksigen'))
                        O<span class="text-sm">2</span>
                    @else
                        N
                    @endif
                </h1>
                <div class="w-full">
                    <h3 class="font-bold text-sm md:text-lg">{{ $pesanan->nama }}</h3>
                    <p class="text-xs md:text-sm">Rp. {{ number_format($pesanan->harga) }}</p>
                </div>
            </div>

            <div class="flex justify-between w-full">
                <div class="flex justify-between items-center w-full">
                    <h3 class="md:text-lg mx-2 text-sm w-10 md:w-full ">x{{ number_format($pesanan->qty) }}</h3>
                    <h3 class="font-bold md:text-lg text-sm w-full">Rp.
                        {{ number_format($pesanan->harga * $pesanan->qty) }}
                    </h3>
                </div>
                <button class="ps-4 md:px-4 text-red-600"
                    wire:click="delete({{ $pesanan->id }})">@svg('heroicon-s-trash', 'w-6 h-6')</button>
            </div>
        </div>
    </div>
</div>
