@php
    $collumn['sm'] = $col['sm'] ?? 1;
    $collumn['md'] = $col['md'] ?? 2;
@endphp

<ul class="grid w-full gap-2 md:gap-6 grid-cols-{{ $collumn['sm'] }} md:grid-cols-{{ $collumn['md'] }} text-center">
    {{ $slot }}
</ul>
