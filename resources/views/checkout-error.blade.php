<x-layouts.app theme="1">
    <section class="">
        <div class="flex items-center py-12 px-4 mx-auto max-w-screen-xl text-left min-h-[78vh]">
            <div class="relative md:w-1/2 mx-auto shadow-lg bg-white rounded border-b">
                <div
                    class="absolute -top-10 left-1/2 -translate-x-1/2 bg-danger-400 text-white rounded-full p-4 inline-block border-8 border-white">
                    <img src="/img/cross-mark.webp" width="50">
                </div>

                <div class="px-4">
                    <div class="flex justify-center items-end text-center pt-20">
                        <h3 class="text-4xl font-semibold">Stok Habis</h3>
                    </div>

                    <p class="text-center text-gray-600 py-4 mb-2.5">Saat ini produk yang Anda cari telah habis. Kami
                        akan
                        segera memberi tahu Anda ketika produk tersebut tersedia kembali.</p>


                    <div class="flex">
                        <a href="{{ url('order/new') }}"
                            class="mx-4 py-2 px-4 text-primary-600 rounded hover:underline w-full mt-8 mb-4 text-center font-semibold">👈
                            Kembali
                            ke pesanan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
