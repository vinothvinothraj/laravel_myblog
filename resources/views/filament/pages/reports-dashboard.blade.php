<x-filament-panels::page>

    <div class="flex justify-end mb-4">

        <x-filament::button color="primary" tag="a" href="{{ route('create-new-report') }}">
            Create New Report
        </x-filament::button>
    </div>

    <div class="mb-8">
        @livewire(\App\Livewire\NewReportsStatsOverview::class)
    </div>


    <div>
        @livewire('report-table')
    </div>
</x-filament-panels::page>
