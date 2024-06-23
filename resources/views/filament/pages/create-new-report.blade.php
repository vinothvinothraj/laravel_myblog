<x-filament-panels::page>

    <div class="flex justify-end mb-4">
        <x-filament::button color="primary" tag="a" href="{{ route('reports-dashboard') }}">
            Back To Report Dashboard
        </x-filament::button>
    </div>

    <form wire:submit.prevent="save">
        {{ $this->form }}
    </form>

</x-filament-panels::page>