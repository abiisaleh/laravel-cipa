<x-filament-panels::page>
    <form wire:submit="create">
        {{ $this->form }}
    </form>

    <div>
        {{ $this->saveAction }}
    </div>

    {{ $this->table }}

    <x-filament-actions::modals />
</x-filament-panels::page>
