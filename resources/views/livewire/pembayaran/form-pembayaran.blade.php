<form wire:submit="save" class="">
    @csrf
    <div class="w-full" x-data="{ total: {{ $total }} }">
        <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Metode pembayaran</h3>
        <div x-data="{ open: false }">
            <x-radio-list col="2">
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
            </x-radio-list>

            <select x-show="open"
                class="mt-4 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                <option selected>Pilih Bank</option>
                @foreach (['BCA', 'BNI', 'BRI', 'BJB', 'BSI', 'BNC', 'CIMB', 'DBS', 'MANDIRI', 'PERMATA', 'SAHABAT_SAMPOERNA'] as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>


        <div class="mt-12">
            <div class="flex justify-between items-center mb-4">
                <p class="text-gray-500">Subtotal untuk produk</p>
                <p class="">Rp. <span x-text="total.toLocaleString()"></span></p>
            </div>

            <div class="flex justify-between items-center mb-4">
                <p class="text-gray-500">Ongkos Kirim</p>
                <p class="">Rp. <span x-text="total.toLocaleString()"></span></p>
            </div>

            <div class="flex justify-between items-center mb-4">
                <p class="text-gray-500">Total Pembayaran</p>
                <p class="text-primary-600 text-2xl font-semibold">Rp. <span x-text="total.toLocaleString()"></span></p>
            </div>

            <input type="submit"
                class="block bg-primary-600 w-full p-5 text-white border border-gray-200 rounded-lg  hover:text-gray-200 hover:bg-primary-800"
                value="Buat Pesanan" />
        </div>
    </div>
</form>
