@php
    $collumn['sm'] = $col['sm'] ?? 1;
    $collumn['md'] = $col['md'] ?? 2;

    $cols = 'grid-cols-' . $collumn['sm'] . ' md:grid-cols-' . $collumn['md'];
@endphp

<ul class="grid w-full gap-2 md:gap-6 text-center {{ $cols }}">
    {{ $slot }}
</ul>
