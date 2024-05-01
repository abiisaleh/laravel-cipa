<div class="border-gray-100 border-2 rounded-md shadow-sm mb-4">
    <div class="flex items-center p-4" x-on:click="open = !open">
        <h1 class="text-xl p-4 font-bold bg-primary-600 text-white rounded-md me-4 w-20 text-center ">
            @if (strpos($pesanan->tabung, 'oksigen'))
                O<span class="text-sm">2</span>
            @else
                N
            @endif
        </h1>
        <div class="w-full">
            <h3 class="font-bold text-lg">{{ $pesanan->tabung }}</h3>
            <p>Rp. {{ number_format($pesanan->harga) }}</p>
        </div>
        <h3 class="text-lg w-80">x{{ number_format($pesanan->jumlah) }}</h3>
        <h3 class="font-bold text-lg w-80">Rp. {{ number_format($pesanan->harga * $pesanan->jumlah) }}</h3>
        <button class="px-4 text-red-600 " wire:click="delete({{ $pesanan->id }})">@svg('heroicon-s-trash', 'w-6 h-6')</button>
    </div>
</div>
