<section class="bg-white">
    <div class="py-16 px-4 mx-auto max-w-screen-xl text-left">
        <h3 class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-4xl">Pesan
            tabung</h3>
        <p class="mb-16 text-lg font-normal text-gray-500 lg:text-xl">Pilih tabung yang ingin dipesan.</p>
        <form wire:submit="save">
            @csrf
            <div class="md:flex justify-center">
                <div class="mb-5">
                    <div class="justify-center flex">
                        <img class="px-16 flex max-h-96 w-auto " src="img/tube.webp" alt="">
                    </div>

                    <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white mt-8">Jumlah</h3>
                    <div class="grid grid-cols-3 text-center md:w-64 mb-2" x-data="{ qty: 0 }">
                        <div x-on:click="qty = qty > 0 ? qty-1 : qty" wire:click="decrement"
                            class="flex items-center justify-center w-full text-gray-500 bg-white border border-gray-200 rounded-lg hover:text-gray-600 hover:bg-gray-100 cursor-pointer">
                            @svg('heroicon-s-minus', 'w-4 h-4')
                        </div>
                        <input type="text" wire:model="form.qty" x-model="qty"
                            class="text-center border-gray-100 focus:border-gray-100 border-x-0 focus:ring-0 font-medium text-4xl text-primary-600" />
                        <div x-on:click="qty = qty < 100 ? qty+1 : 100" wire:click="increment"
                            class="flex items-center justify-center  w-full text-gray-500 bg-white border border-gray-200 rounded-lg hover:text-gray-600 hover:bg-gray-100 cursor-pointer">
                            @svg('heroicon-s-plus', 'w-4 h-4')
                        </div>
                    </div>
                </div>
                <div class="md:ps-16 w-full">
                    <x-radio-list col="2">
                        <x-radio-btn id="jenis-oksigen" name="jenis" value="6">
                            <h1 class="text-8xl w-full pb-4 font-bold">O<span class="text-xl">2</span></h1>
                            <div class="w-full">Oksigen</div>
                        </x-radio-btn>
                        <x-radio-btn id="jenis-nitrogen" name="jenis" value="7">
                            <h1 class="text-8xl w-full pb-4 font-bold">N</h1>
                            <div class="w-full">Nitrogen</div>
                        </x-radio-btn>
                    </x-radio-list>

                    <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white mt-8">Ukuran</h3>
                    <x-radio-list col="3">
                        @foreach (['kecil' => 200, 'sedang' => 300, 'besar' => 400] as $key => $value)
                            <x-radio-btn id="ukuran-{{ $value }}" name="ukuran" :$value>
                                <div class="w-full">{{ ucfirst($key) }}</div>
                            </x-radio-btn>
                        @endforeach
                    </x-radio-list>

                    <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white mt-8">Jenis</h3>
                    <x-radio-list col="3">
                        @foreach (['full', 'refill', 'kosong'] as $value)
                            <x-radio-btn id="isi-{{ $value }}" name="isi" :$value>
                                <div class="w-full">{{ ucfirst($value) }}</div>
                            </x-radio-btn>
                        @endforeach
                    </x-radio-list>

                    <div class="mt-12">
                        <x-radio-list col="2">
                            <li>
                                <input value="Masukkan ke keranjang" type="button" wire:click="addToCard"
                                    class="block w-full p-5 text-primary-600 bg-white border border-primary-600 rounded-lg hover:bg-gray-100 cursor-pointer" />
                            </li>
                            <li>
                                <input type="submit"
                                    class="block bg-primary-600 w-full p-5 text-white border border-gray-200 rounded-lg  hover:text-gray-200 cursor-pointer hover:bg-primary-800"
                                    value="Pesan sekarang" />
                            </li>
                        </x-radio-list>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
