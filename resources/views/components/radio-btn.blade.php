@php
    if ($attributes->has('id')) {
        $id = $attributes->get('id');
    } else {
        $id = $name . $value;
    }
@endphp

<li>
    <input type="radio" id="{{ $id }}" wire:model="{{ $name }}" name="{{ $name }}"
        value="{{ $value }}" class="hidden peer" required />
    <label for="{{ $id }}"
        class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg peer-checked:text-primary-500 peer-checked:border-2 peer-checked:border-primary-600 hover:text-gray-600 hover:bg-gray-100 ">
        <div class="block w-full">
            {{ $slot }}
        </div>
    </label>
</li>
