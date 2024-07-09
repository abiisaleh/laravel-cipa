<section class="bg-white">
    <div class="py-16 px-4 mx-auto max-w-screen-xl text-left" x-data="{ open: false }">
        <h3 class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-4xl">
            Pesan
            tabung
        </h3>
        <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl"><span class="animate-shake inline-block">🛒</span>
            Pilih tabung yang ingin dipesan.</p>

        <div>
            <form wire:submit="create">
                {{ $this->form }}
            </form>

            <x-filament-actions::modals />
        </div>

    </div>
</section>
