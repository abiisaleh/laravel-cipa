<section class="bg-white">
    <div class="py-12 px-4 mx-auto max-w-screen-xl text-left">
        <div class="md:w-1/2 mx-auto">

            <img class="mx-auto py-4" src="/img/money.webp" alt="animasi uang" width="200">

            <div class="flex justify-between py-4 border-b-2 items-center">
                <p>Total Pembayaran</p>
                <p class="text-primary-600 font-semibold">Rp {{ number_format($record->subtotal) }}</p>
            </div>

            <div class="flex justify-between py-4 border-b-2 items-center">
                <p>Bayar Dalam</p>
                <div class="text-right">
                    <x-countdown :expires="$date" class="text-primary-600 font-semibold">
                        <span>{{ $component->days() == '00' ? '' : $component->days() . ' hari' }}</span>
                        <span x-text="timer.hours"></span> jam
                        <span x-text="timer.minutes"></span> menit
                        <span x-text="timer.seconds"></span> detik
                    </x-countdown>

                    <small class=" text-gray-500">Jatuh tempo {{ $date->format('d M Y, H:m') }}</small>
                </div>
            </div>

            <div class="py-4">
                @if ($record->metode == 'Cash')
                    <p>Pembayaran Tunai (Cash)</p>
                    <div class="text-sm py-4">
                        <p class="pb-4 text-danger-600">Harap melakukan pembayaran agar tidak di kenakan denda
                            bulanan sebesar {{ $persentaseDenda ?? 5 }}%.</p>
                        <p class="pb-4">Pembayaran tunai Anda akan diverifikasi oleh admin dalam
                            waktu maksimal 24 jam setelah transaksi dilakukan.</p>
                        <p>Hanya menerima pembayaran tunai di kantor atau melalui petugas kami.</p>
                    </div>

                    <p class="text-center">
                        <a href="{{ url('/') }}" class="text-sm font-semibold text-primary-600 hover:underline">👈
                            Kembali
                            ke
                            menu utama</a>
                    </p>
                @else
                    <p>Bank {{ ucfirst($record->metode) }}</p>
                    <div class="text-sm py-4">
                        <p>No. Rekening</p>
                        <div class="flex pb-4 items-center">
                            <h3 class="text-lg text-primary-600 font-semibold me-4">{{ $va['account_number'] }}
                            </h3>
                            <button
                                class="text-green-800 bg-green-100 hover:bg-green-200 text-xs font-semibold p-0.5 px-2.5 rounded "
                                onclick="navigator.clipboard.writeText('{{ $va['account_number'] }}').then(alert('disalin'))">Salin</button>
                        </div>
                        <p class="pb-4 text-green-600">Proses verifikasi kurang dari 10 menit setelah pembayaran</p>
                        <p class="pb-4">Bayar pesanan ke Virtual Account di atas sebelum membuat pesanan kembali
                            dengan nomor Virtual Account yang sama.</p>
                        <p>Hanya menerima Bank {{ ucfirst($record->metode) }}</p>

                        <div class="bg-info-50 p-2 mt-8 flex items-center justify-center text-center">
                            <p class="">Untuk mensimulasikan pembayaran klik {{ $this->simulateAction }}</p>
                        </div>
                @endif
            </div>
        </div>
</section>
