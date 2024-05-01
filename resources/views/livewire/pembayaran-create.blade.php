<section class="bg-white min-h-[80vh]">
    <div class="py-16 px-4 mx-auto max-w-screen-xl text-left">
        <h3 class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-4xl">
            Pembayaran</h3>
        <p class="mb-16 text-lg font-normal text-gray-500 lg:text-xl">Silahkan isi form dibawah ini untuk melakukan
            pembayaran.
        </p>

        @forelse ($items as $pesanan)
            <x-pesanan-list :$pesanan key="$pesanan->id" />
        @empty
            <p class="p-5 bg-primary-100 rounded-md text-center text-gray-500">pesanan belum dibuat</p>
        @endforelse

        @if ($items->isNotEmpty())
            <form>
                @csrf
                <div class="w-full" x-data="{ open: false }">
                    <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white mt-8">Metode pembayaran</h3>
                    <x-radio-list col="4">
                        @foreach (['BCA', 'BNI', 'BRI', 'BJB', 'BSI', 'BNC', 'MANDIRI', 'PERMATA'] as $value)
                            <x-radio-btn name="ukuran" :$value>
                                <div class="w-full">{{ ucfirst($value) }}</div>
                            </x-radio-btn>
                        @endforeach
                    </x-radio-list>

                    <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white mt-8">Jenis Pembayaran</h3>
                    <x-radio-list col="2">
                        <x-radio-btn name="isi" value="cicil">
                            <div class="w-full" x-on:click = "open = true">Cicil</div>
                        </x-radio-btn>
                        <x-radio-btn name="isi" value="full">
                            <div class="w-full" x-on:click = "open = false">Full</div>
                        </x-radio-btn>
                    </x-radio-list>

                    <div x-show="open">
                        <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white mt-8">
                            Jumlah DP</h3>
                        <div class="w-full relative" x-data="{ qty: 0 }">
                            <span
                                class="absolute start-0 bottom-3 ps-5 font-medium text-4xl text-gray-500 dark:text-gray-400">Rp.</span>
                            <input type="text" name="qty" x-model="qty"
                                class="w-full ps-20 border-gray-100 focus:border-gray-100 focus:ring-0 font-medium text-4xl text-primary-600">
                        </div>
                    </div>

                    <div class="mt-12">
                        <div class="flex justify-between items-center mb-8 ">
                            <p class="text-xl">Total</p>
                            <p class="font-bold text-2xl">Rp. {{ number_format($total) }}</p>
                        </div>
                        <input type="submit"
                            class="block bg-primary-600 w-full p-5 text-white border border-gray-200 rounded-lg  hover:text-gray-200 hover:bg-primary-800"
                            value="Bayar" />
                    </div>
                </div>
            </form>
        @endif

    </div>
</section>
