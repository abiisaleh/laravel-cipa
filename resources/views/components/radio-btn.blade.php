<li>
    <input type="radio" id="{{ $name }}-{{ $value }}" wire:model="form.{{ $name }}"
        name="{{ $name }}" value="{{ $value }}" class="hidden peer" required />
    <label for="{{ $name }}-{{ $value }}"
        class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg peer-checked:border-primary-600 peer-checked:text-white peer-checked:bg-primary-600 hover:text-gray-600 hover:bg-gray-100 ">
        <div class="block w-full">
            {{ $slot }}
        </div>
    </label>
</li>
