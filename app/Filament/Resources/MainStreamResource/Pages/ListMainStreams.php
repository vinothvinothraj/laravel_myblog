<?php

namespace App\Filament\Resources\MainStreamResource\Pages;

use App\Filament\Resources\MainStreamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMainStreams extends ListRecords
{
    protected static string $resource = MainStreamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
