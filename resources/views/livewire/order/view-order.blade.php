<section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Detail Pesanan</h2>

        <div class="mt-6 sm:mt-8 lg:flex lg:gap-8">
            <div
                class="w-full divide-y h-fit  divide-gray-200 overflow-hidden rounded-lg border border-gray-200 lg:max-w-xl xl:max-w-2xl ">

                @foreach ($items as $pesanan)
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="bg-white flex justify-between w-full  md:p-4 py-6 px-2">
                                <div class="flex items-center w-full ">
                                    @if (strpos($pesanan->nama, 'oksigen'))
                                        <h1
                                            class=" text-xl p-2 md:p-4 font-bold bg-green-200 text-green-800 rounded-md me-4  w-10 md:w-20 text-center ">
                                            O₂
                                        </h1>
                                    @else
                                        <h1
                                            class=" text-xl p-2 md:p-4 font-bold bg-indigo-400 text-indigo-800 rounded-md me-4  w-10 md:w-20 text-center ">
                                            N
                                        </h1>
                                    @endif

                                    <div class="w-full">
                                        <h3 class="font-semibold text-sm md:text-base">{{ $pesanan->nama }}</h3>
                                        <div class="flex justify-between items-center w-full">
                                            <p class="text-xs md:text-sm">Rp. {{ number_format($pesanan->harga) }}
                                            </p>
                                            <div class="flex items-center">
                                                <h3 class="md:text-base mx-2 text-sm w-10">
                                                    x{{ number_format($pesanan->qty) }}</h3>
                                                <h3 class="font-semibold md:text-base text-sm">Rp.
                                                    {{ number_format($pesanan->harga * $pesanan->qty) }}
                                                </h3>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach

                <div class="space-y-4 bg-gray-50 p-6 ">
                    <div class="space-y-2">
                        <dl class="flex items-center justify-between gap-4">
                            <dt class="font-normal text-gray-500 ">Subtotal untuk produk</dt>
                            <dd class="font-medium text-gray-900 ">Rp {{ number_format($record->subtotal) }}</dd>
                        </dl>

                        <dl class="flex items-center justify-between gap-4">
                            <dt class="font-normal text-gray-500 ">Ongkos Kirim</dt>
                            <dd class="text-base font-medium">Rp {{ number_format($record->ongkir) }}</dd>
                        </dl>

                        <dl class="flex items-center justify-between gap-4">
                            <dt class="font-normal text-gray-500 ">Denda</dt>
                            <dd class="font-medium text-gray-900 ">Rp {{ number_format($record->denda) }}</dd>
                        </dl>
                    </div>

                    <dl
                        class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                        <dt class="text-lg font-bold text-gray-900 ">Total</dt>
                        <dd class="text-lg font-bold text-gray-900 ">Rp {{ number_format($record->total) }}</dd>
                    </dl>

                    <dl class="flex items-center justify-between gap-4">
                        <dt class="font-normal text-gray-500 ">Metode Pembayaran</dt>
                        <dd class="font-medium text-gray-900 ">{{ $record->metode }}</dd>
                    </dl>
                </div>
            </div>

            <div class="mt-6 grow sm:mt-8 lg:mt-0">
                <div
                    class="space-y-6 rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Riwayat pesanan</h3>

                    <ol class="relative ms-3 border-s border-gray-200 dark:border-gray-700">

                        @if ($record->trashed())
                            <x-list-timeline icon="heroicon-o-trash" :text="date_create($record->deleted_at)->format('d M Y, h:i')">
                                Pesanan dibatalkan
                            </x-list-timeline>
                        @endif

                        @if ($record->metode == 'Cash')
                            @if ($record->lunas)
                                <x-list-timeline icon="heroicon-o-credit-card" :text="date_create($record->tgl_lunas)->format('d M Y, h:i')">
                                    Pembayaran diterima
                                </x-list-timeline>
                            @endif

                            @if ($record->diterima)
                                <x-list-timeline icon="heroicon-o-clock" text="Menungu Pembayaran">
                                    Segera lakukan pembayaran
                                </x-list-timeline>

                                <x-list-timeline icon="heroicon-o-home" :text="date_create($record->tgl_diterima)->format('d M Y, h:i')">
                                    Pesanan telah sampai
                                    diterima oleh yang bersangkutan.
                                </x-list-timeline>
                            @endif

                            <x-list-timeline icon="heroicon-o-truck" text="Diantar">
                                Pesanan dalam proses
                                pengantaran
                            </x-list-timeline>
                        @else
                            @if ($record->diterima)
                                <x-list-timeline icon="heroicon-o-home" :text="date_create($record->tgl_diterima)->format('d M Y, h:i')">
                                    Pesanan telah sampai
                                    diterima oleh yang bersangkutan. <a href="#"
                                        class="text-sm font-semibold text-primary-600 hover:underline">Lihat Bukti
                                        Pengiriman.</a>
                                </x-list-timeline>
                            @endif

                            @if ($record->lunas)
                                <x-list-timeline icon="heroicon-o-truck" text="Diantar">
                                    Pesanan dalam proses
                                    pengantaran
                                </x-list-timeline>
                            @endif

                            @if ($record->lunas)
                                <x-list-timeline icon="heroicon-o-credit-card" :text="date_create($record->tgl_lunas)->format('d M Y, h:i')">
                                    Pembayaran diterima - Virtual Account Bank {{ $record->metode }} <br>
                                    <a href="{{ url('checkout', $record->id) }}"
                                        class="text-sm font-semibold text-primary-600 hover:underline">Lihat Bukti
                                        Pembayaran.</a>
                                </x-list-timeline>
                            @endif

                            <x-list-timeline icon="heroicon-o-clock" text="Menungu Pembayaran">
                                Segera lakukan pembayaran
                            </x-list-timeline>
                        @endif

                        <x-list-timeline icon="heroicon-o-shopping-cart" :text="date_create($record->created_at)->format('d M Y, h:i')">
                            Pesanan Dibuat
                        </x-list-timeline>


                    </ol>

                    <div class="gap-4 flex-col flex sm:flex-row sm:items-center" id="btn-timeline">
                        @if ($record->trashed())
                            {{ $this->restoreAction }}
                        @else
                            @if (!$record->lunas & !$record->diterima)
                                {{ $this->deleteAction }}

                                {{ $this->checkoutAction }}
                            @endif
                        @endif
                    </div>



                </div>
            </div>
        </div>

        <x-filament-actions::modals />
    </div>


</section>
