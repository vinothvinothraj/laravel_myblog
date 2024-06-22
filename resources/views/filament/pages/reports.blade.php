<x-filament-panels::page>
    {{-- <div>
        @livewire('main-stream-table')
    </div> --}}

    <div>
        @livewire('report-table')
    </div>
    
<form wire:submit.prevent="save">
  {{ $this->form }}
</form>

</x-filament-panels::page>
