<section class=" min-h-[80vh]">
    <div class="py-16 px-4 mx-auto max-w-screen-xl text-left">

        <div class="flex rounded-lg border-gray-200 border py-4 px-6 items-center mb-6">
            <img class=" w-10 h-10 md:w-16 md:h-16 border-primary-600 border-2 rounded-full"
                src="{{ filament()->getUserAvatarUrl(auth()->user()) }}" alt="user photo">
            <div class="flex w-full justify-between items-center">
                <div class="w-auto mx-4">
                    <div class="flex items-center">
                        <h3 class="md:text-lg font-semibold text-md me-2">{{ auth()->user()->name }}</h3>
                        <a href="{{ filament()->getProfileUrl() }}">@svg('heroicon-c-pencil-square', 'w-4 text-primary-600')</a>
                    </div>
                    <p class="text-sm md:text-md">{{ auth()->user()->email }}</p>
                </div>
                <div class="">
                    @if (auth()->user()->pelanggan == null)
                        <span class="text-xs font-semibold py-0.5 px-2.5 rounded text-danger-800 bg-danger-100">not
                            registered
                        </span>
                    @else
                        <span
                            class="text-xs font-semibold py-0.5 px-2.5 rounded {{ auth()->user()->pelanggan->verified ? 'text-success-800 bg-success-100' : 'text-danger-800 bg-danger-100' }}">
                            {{ auth()->user()->pelanggan->verified ? 'verified' : 'not verified' }}
                        </span>
                    @endif
                </div>

            </div>
        </div>

        <div class="mb-8 grid">
            <form wire:submit="create">
                {{ $this->form }}

                <div class="flex md:justify-end">
                    <button type="submit"
                        class="py-2 px-4 bg-primary-600 rounded hover:bg-primary-800 mt-8 mb-4 text-white">
                        Simpan perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
