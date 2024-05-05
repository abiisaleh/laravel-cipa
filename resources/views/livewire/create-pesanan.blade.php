<section class="bg-white">
    <div class="py-16 px-4 mx-auto max-w-screen-xl text-left" x-data="{ open: false }">
        <h3 class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-4xl">
            Pesan
            tabung
        </h3>
        <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl"><span class="animate-shake inline-block">🛒</span>
            Pilih tabung yang ingin dipesan.</p>
        <div class="grid md:flex gap-4">
            <div class="w-full">
                <div class="flex grow">
                    <form wire:submit="addToCart" class="w-full">
                        @csrf
                        <div class="md:flex justify-center">
                            <div class="w-full">
                                <ul class="grid w-full gap-2 md:gap-6 grid-cols-2 text-center">
                                    <div wire:click="cekTabung">
                                        <x-radio-btn id="jenis-oksigen" name="jenis" value="oksigen">
                                            <h1 class="text-8xl w-full pb-4 font-bold">O₂</h1>
                                            <div class="text-sm w-full">Oksigen</div>
                                        </x-radio-btn>
                                    </div>

                                    <div wire:click="cekTabung">
                                        <x-radio-btn id="jenis-nitrogen" name="jenis" value="nitrogen"
                                            wire:click="cekTabung">
                                            <h1 class="text-8xl w-full pb-4 font-bold">N</h1>
                                            <div class="text-sm w-full">Nitrogen</div>
                                        </x-radio-btn>
                                    </div>
                                </ul>

                                <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white mt-8">Ukuran</h3>
                                <ul class="grid w-full gap-2 md:gap-6 grid-cols-3 text-center">
                                    @foreach (['kecil', 'sedang', 'besar'] as $value)
                                        <div wire:click="cekUkuran">
                                            <x-radio-btn id="ukuran-{{ $value }}" name="ukuran" :$value>
                                                <div class="w-full">
                                                    <h4 class="text-sm md:text-md font-semibold">
                                                        {{ ucfirst($value) }}
                                                    </h4>
                                                    <p class="text-sm md:text-md">
                                                        {{ number_format($berat[$value] ?? 0) }} g
                                                    </p>
                                                </div>
                                            </x-radio-btn>
                                        </div>
                                    @endforeach
                                </ul>
                                <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white mt-8">Jenis</h3>
                                <ul class="grid w-full gap-2 md:gap-6 grid-cols-3 text-center">

                                    <div wire:click="cekHarga('full')">
                                        <x-radio-btn id="harga-full" name="harga"
                                            value="{{ $tabung['harga_full'] ?? 0 }}">
                                            <div class="w-full">
                                                <h4 class="text-sm md:text-md font-semibold">Full</h4>
                                                <p class="text-sm md:text-md">Rp
                                                    {{ number_format($tabung['harga_full'] ?? 0) }}</p>
                                            </div>
                                        </x-radio-btn>
                                    </div>

                                    <div wire:click="cekHarga('kosong')">
                                        <x-radio-btn id="harga-kosong" name="harga"
                                            value="{{ $tabung['harga_kosong'] ?? 0 }}">
                                            <div class="w-kosong">
                                                <h4 class="text-sm md:text-md font-semibold">Kosong</h4>
                                                <p class="text-sm md:text-md">Rp
                                                    {{ number_format($tabung['harga_kosong'] ?? 0) }}</p>
                                            </div>
                                        </x-radio-btn>
                                    </div>

                                    <div wire:click="cekHarga('refill')">
                                        <x-radio-btn id="harga-refill" name="harga"
                                            value="{{ $tabung['harga_refill'] ?? 0 }}">
                                            <div class="w-refill">
                                                <h4 class="text-sm md:text-md font-semibold">Refill</h4>
                                                <p class="text-sm md:text-md">Rp
                                                    {{ number_format($tabung['harga_refill'] ?? 0) }}</p>
                                            </div>
                                        </x-radio-btn>
                                    </div>
                                </ul>


                                <div class="md:grid md:grid-cols-2 gap-4">
                                    <div class="">
                                        <h3 class="mb-5 text-lg font-medium text-gray-900 mt-8">Jumlah</h3>
                                        <div class="flex text-center mb-2 w-48" x-data="{ qty: 1 }">
                                            <div class="relative w-full">
                                                <div x-on:click="qty = qty > 1 ? qty-1 : qty" wire:click="decrement"
                                                    class="absolute start-0 bottom-0 text-gray-500 bg-white border border-gray-200 rounded-lg p-5 hover:text-gray-600 hover:bg-gray-100 cursor-pointer">
                                                    @svg('heroicon-s-minus', ['class' => 'w-2 h-2 md:w-4 md:h-4'])
                                                </div>
                                                <input type="number" wire:model="label.qty" x-model="qty" disabled
                                                    class="ps-7 text-center border-gray-100 focus:border-gray-100 border-x-0 focus:ring-0 font-medium text-2xl md:text-4xl text-primary-600 w-full rounded-lg" />
                                                <div x-on:click="qty = qty < 99 ? qty+1 : 99" wire:click="increment"
                                                    class="absolute end-0 bottom-0 text-gray-500 bg-white border border-gray-200 rounded-lg p-5 hover:text-gray-600 hover:bg-gray-100 cursor-pointer">
                                                    @svg('heroicon-s-plus', ['class' => 'w-2 h-2 md:w-4 md:h-4'])
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between md:pt-16">
                                        <h3 class="mb-5 text-lg font-medium text-gray-900 mt-8">Total</h3>
                                        <h2 class="text-2xl md:text-4xl font-bold text-right">Rp.
                                            {{ number_format($harga * $qty) }}
                                        </h2>
                                    </div>
                                </div>

                                <div class="mt-12">
                                    <button type="submit"
                                        class="block w-full p-5 text-primary-600 bg-white border border-primary-600 rounded-lg hover:bg-gray-100 cursor-pointer">
                                        Masukkan ke keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="w-full hidden md:block">
                <div class="bg-gray-50 rounded p-4">
                    <div class="w-full grow">
                        <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Keranjang</h3>
                        @forelse ($items as $pesanan)
                            <div wire:key="{{ $pesanan->id }}">
                                <x-pesanan-list :$pesanan />
                            </div>
                        @empty
                            <p class="p-5 rounded-md text-center text-gray-500 mb-4">- Kosong -</p>
                        @endforelse
                    </div>

                    <form action="{{ url('/checkout/new') }}">
                        @csrf
                        <div class="w-full">
                            <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Metode pembayaran</h3>
                            <div x-data="{ open: false }">
                                <ul class="grid w-full gap-2 md:gap-6 grid-cols-2 text-center">
                                    <div x-on:click="open = false">
                                        <x-radio-btn name="jenis-pembayaran" value="cash">
                                            <div class="w-full">Cash</div>
                                        </x-radio-btn>
                                    </div>
                                    <div x-on:click="open = true">
                                        <x-radio-btn name="jenis-pembayaran" value="transfer">
                                            <div class="w-full">Transfer Bank</div>
                                        </x-radio-btn>
                                    </div>
                                </ul>

                                <select x-show="open" name="metode"
                                    class="mt-4 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                    <option value="cash" selected>Pilih Bank</option>
                                    @foreach (['BCA', 'BNI', 'BRI', 'BJB', 'BSI', 'BNC', 'CIMB', 'DBS', 'MANDIRI', 'PERMATA', 'SAHABAT_SAMPOERNA'] as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-12">
                                <div class="flex justify-between items-center mb-4">
                                    <p class="text-gray-500">Subtotal untuk produk</p>
                                    <p class="">Rp {{ number_format($subtotal) }}</p>
                                </div>

                                <div class="flex justify-between items-center mb-4">
                                    <p class="text-gray-500">Ongkos Kirim</p>
                                    <p class="">Rp {{ number_format($ongkir) }}</p>
                                </div>

                                <div class="flex justify-between items-center mb-4">
                                    <p class="text-gray-500">Total Pembayaran</p>
                                    <p class="text-primary-600 text-2xl font-semibold">Rp
                                        {{ number_format($subtotal + $ongkir) }}
                                    </p>
                                </div>

                                <button type="submit" {{ $items->isEmpty() ? 'disabled' : '' }}
                                    class="block bg-primary-600 w-full p-5 text-white border border-gray-200 rounded-lg  hover:text-gray-200 hover:bg-primary-800 {{ $items->isEmpty() ? 'disabled:bg-gray-100 disabled:text-gray-500' : '' }}">Buat
                                    Pesanan</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- cart btn --}}
        <button
            class="md:hidden  fixed bottom-10 end-5 bg-primary-600 p-4 text-white rounded-full shadow-xl hover:shadow-none hover:bg-primary-800"
            x-on:click="open = !open">
            @svg('heroicon-o-shopping-cart', ['class' => 'w-6 h-6', ':class' => 'open ? "hidden" : ""'])
            @svg('heroicon-o-x-mark', ['class' => 'w-6 h-6', ':class' => 'open ? "" : "hidden"'])
        </button>

        <aside id="sidebar"
            class="md:hidden bg-gray-50 w-3/4 space-y-6 pt-6 px-0 fixed inset-y-0 left-0 transform transition duration-200 ease-in-out overflow-x-auto"
            :class="open ? 'translate-x-0' : '-translate-x-full'">
            <div class="flex flex-col space-y-6">
                <div class="rounded p-4">
                    <div class="w-full grow">
                        <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Keranjang</h3>
                        @forelse ($items as $pesanan)
                            <div wire:key="{{ $pesanan->id }}">
                                <x-pesanan-list :$pesanan />
                            </div>
                        @empty
                            <p class="p-5 rounded-md text-center text-gray-500 mb-4">- Kosong -</p>
                        @endforelse
                    </div>

                    <form action="{{ url('/checkout/new') }}">
                        @csrf
                        <div class="w-full">
                            <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Metode pembayaran
                            </h3>
                            <div x-data="{ open: false }" class="text-xs md:text-md">
                                <ul class="grid w-full gap-2 md:gap-6 grid-cols-2 text-center">
                                    <div x-on:click="open = false">
                                        <x-radio-btn name="ukuran" value="cash">
                                            <div class="w-full">Cash</div>
                                        </x-radio-btn>
                                    </div>
                                    <div x-on:click="open = true">
                                        <x-radio-btn name="ukuran" value="transfer">
                                            <div class="w-full">Transfer Bank</div>
                                        </x-radio-btn>
                                    </div>
                                </ul>

                                <select x-show="open"
                                    class="mt-4 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                    <option selected>Pilih Bank</option>
                                    @foreach (['BCA', 'BNI', 'BRI', 'BJB', 'BSI', 'BNC', 'CIMB', 'DBS', 'MANDIRI', 'PERMATA', 'SAHABAT_SAMPOERNA'] as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-12 text-sm md:text-md">
                                <div class="flex justify-between items-center mb-4">
                                    <p class="text-gray-500">Subtotal untuk produk</p>
                                    <p class="">Rp {{ number_format($subtotal) }}</p>
                                </div>

                                <div class="flex justify-between items-center mb-4">
                                    <p class="text-gray-500">Ongkos Kirim</p>
                                    <p class="">Rp {{ number_format($ongkir) }}</p>
                                </div>

                                <div class="flex justify-between items-center mb-4">
                                    <p class="text-gray-500">Total Pembayaran</p>
                                    <p class="text-primary-600 text-xl md:text-2xl font-semibold">Rp
                                        {{ number_format($subtotal + $ongkir) }}
                                    </p>
                                </div>

                                <button type="submit" {{ $items->isEmpty() ? 'disabled' : '' }}
                                    class="block bg-primary-600 w-full p-5 text-white border border-gray-200 rounded-lg  hover:text-gray-200 hover:bg-primary-800 {{ $items->isEmpty() ? 'disabled:bg-gray-100 disabled:text-gray-500' : '' }}">Buat
                                    Pesanan</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </aside>
    </div>

</section>
