<div class="border-gray-100 border-2 rounded-lg mb-4 bg-red-600">
    <div class="flex items-center" x-data="{ open: false }">
        <div class="bg-white flex justify-between w-full  md:p-4 py-6 px-2 cursor-pointer hover:shadow rounded-r transition-shadow"
            x-on:click="open = !open">
            <div class="flex items-center w-full ">
                @if (strpos($pesanan->nama, 'oksigen'))
                    <h1 x-show="!open"
                        class="md:hidden text-xl p-2 md:p-4 font-bold bg-green-200 text-green-800 rounded-md me-4  w-10 md:w-20 text-center ">
                        O₂
                    </h1>

                    <h1
                        class="hidden md:block text-xl p-2 md:p-4 font-bold bg-green-200 text-green-800 rounded-md me-4  w-10 md:w-20 text-center ">
                        O₂
                    </h1>
                @else
                    <h1 x-show="!open"
                        class="md:hidden text-xl p-2 md:p-4 font-bold bg-indigo-400 text-indigo-800 rounded-md me-4  w-10 md:w-20 text-center ">
                        N
                    </h1>

                    <h1
                        class="hidden md:block text-xl p-2 md:p-4 font-bold bg-indigo-400 text-indigo-800 rounded-md me-4  w-10 md:w-20 text-center ">
                        N
                    </h1>
                @endif

                <div class="w-full">
                    <h3 class="font-semibold text-sm md:text-base">{{ $pesanan->nama }}</h3>
                    <div class="flex justify-between items-center w-full">
                        <p class="text-xs md:text-sm">Rp. {{ number_format($pesanan->harga) }}</p>
                        <div class="flex items-center">
                            <h3 class="md:text-base mx-2 text-sm w-10">x{{ number_format($pesanan->qty) }}</h3>
                            <h3 class="font-semibold md:text-base text-sm">Rp.
                                {{ number_format($pesanan->harga * $pesanan->qty) }}
                            </h3>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <button class="px-4 md:px-4 text-white py-8 rounded-r hover:bg-red-800" x-show="open"
            x-transition:enter.duration.300ms x-transition:leave.duration.100ms
            wire:click="delete({{ $pesanan->id }})">@svg('heroicon-o-trash', 'w-6 h-6')</button>
    </div>
</div>
