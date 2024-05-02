<section class="bg-white min-h-[80vh]">
    <div class="py-16 px-4 mx-auto max-w-screen-xl text-left">
        <h3 class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-4xl">
            Pembayaran</h3>
        <p class="mb-16 text-lg font-normal text-gray-500 lg:text-xl">Silahkan isi form dibawah ini untuk melakukan
            pembayaran.
        </p>

        @forelse ($items as $pesanan)
            <div wire:key="{{ $pesanan->id }}">
                <x-pesanan-list :$pesanan />
            </div>
        @empty
            <p class="p-5 bg-primary-100 rounded-md text-center text-gray-500">pesanan belum dibuat</p>
        @endforelse

        @if ($items->isNotEmpty())
            <form wire:submit="save">
                @csrf
                <div class="w-full" x-data="{ total: {{ $total }} }">
                    <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white mt-8">Metode pembayaran</h3>
                    <x-radio-list col="4">
                        @foreach ($banks as $value)
                            <x-radio-btn name="ukuran" :$value>
                                <div class="w-full">{{ ucfirst($value) }}</div>
                            </x-radio-btn>
                        @endforeach
                    </x-radio-list>

                    <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white mt-8">Jenis Pembayaran</h3>
                    <x-radio-list col="2">
                        <div x-on:click="total = {{ $total }} / 2">
                            <x-radio-btn name="isi" value="cicil">
                                <div class="w-full">
                                    <p class="text-2xl font-bold">Cicil</p>
                                    <small>bayar DP 50%</small>
                                </div>
                            </x-radio-btn>
                        </div>
                        <div x-on:click="total = {{ $total }}">
                            <x-radio-btn name="isi" value="full">
                                <div class="w-full">
                                    <p class="text-2xl font-bold">Full</p>
                                    <small>Bayar lunas</small>
                                </div>
                            </x-radio-btn>
                        </div>
                    </x-radio-list>

                    <div class="mt-12">
                        <div class="flex justify-between items-center mb-8">
                            <p class="text-xl">Total</p>
                            <p class="font-bold text-2xl">Rp. <span x-text="total.toLocaleString()"></span></p>
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
