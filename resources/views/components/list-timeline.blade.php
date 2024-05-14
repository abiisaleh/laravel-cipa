<li class="mb-10 ms-6">
    <span class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 ring-8 ring-white">
        @svg($icon, 'w-4 h-4 text-gray-500')
    </span>
    <h4 class="mb-0.5 font-semibold">
        {{ $text }}
    </h4>
    <p class="text-sm text-gray-500">
        {{ $slot }}
    </p>
</li>
