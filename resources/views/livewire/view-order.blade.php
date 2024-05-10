<section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Detail Pesanan
            #957684673</h2>

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

                        @if ($record->tgl_diterima)
                            <li class="mb-10 ms-6 text-primary-700">
                                <span
                                    class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 ring-8 ring-white ">
                                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                    </svg>
                                </span>
                                <h4 class="mb-0.5 text-base font-semibold text-gray-900 ">
                                    {{ date_create($record->tgl_diterima)->format('d M Y, h:i') }}
                                </h4>
                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    Pesanan telah sampai
                                    diterima oleh yang bersangkutan. <a href="#"
                                        class="text-sm font-semibold text-primary-600 hover:underline">Lihat Bukti
                                        Pengiriman.</a>

                                </p>
                            </li>
                        @endif

                        @if ($record->tgl_lunas)
                            <li class="mb-10 ms-6">
                                <span
                                    class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 ring-8 ring-white dark:bg-gray-700 dark:ring-gray-800">
                                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                    </svg>
                                </span>
                                <h4 class="mb-0.5 text-base font-semibold text-gray-900 dark:text-white">Diantar</h4>
                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Pesanan dalam proses
                                    pengantaran</p>
                            </li>

                            <li class="mb-10 ms-6 text-primary-700">
                                <span
                                    class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-primary-100 ring-8 ring-white">
                                    <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                    </svg>
                                </span>
                                <h4 class="mb-0.5 font-semibold">
                                    {{ date_create($record->tgl_lunas)->format('d M Y, h:i') }}
                                </h4>
                                <p class="text-sm">Pembayaran diterima - Virtual Account Bank Mandiri</p>
                            </li>
                        @endif


                        <li class="mb-10 ms-6 {{ $record->tgl_lunas ? '' : 'text-primary-700' }}">
                            <span
                                class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-primary-100 ring-8 ring-white">
                                <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                            </span>
                            <h4 class="mb-0.5 font-semibold">
                                {{ $record->tgl_lunas ? date_create($record->tgl_lunas)->format('d M Y, h:i') : 'Menungu Pembayaran' }}
                            </h4>
                            <p class="text-sm">
                                {{ $record->tgl_lunas ? 'Pembayaran diterima - Virtual Account Bank Mandiri' : 'Segera lakukan pembayaran' }}
                            </p>
                        </li>

                        <li class="ms-6 text-primary-700 dark:text-primary-500">
                            <span
                                class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-primary-100 ring-8 ring-white dark:bg-primary-900 dark:ring-gray-800">
                                <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                            </span>
                            <div>
                                <h4 class="mb-0.5 font-semibold">
                                    {{ date_create($record->created_at)->format('d M Y, h:i') }}</h4>
                                <p class="text-sm">Pesanan Dibuat</p>
                            </div>
                        </li>
                    </ol>

                    <div class="gap-4 sm:flex sm:items-center">
                        <button type="button"
                            class="w-full rounded-lg  border border-gray-200 bg-white px-5  py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">Cancel
                            the order</button>

                        <a href="#"
                            class="mt-4 flex w-full items-center justify-center rounded-lg bg-primary-700  px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300  dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 sm:mt-0">Bayar
                            Sekarang</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
