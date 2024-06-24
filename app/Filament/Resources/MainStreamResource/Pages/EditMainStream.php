<?php

namespace App\Filament\Resources\MainStreamResource\Pages;

use App\Filament\Resources\MainStreamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMainStream extends EditRecord
{
    protected static string $resource = MainStreamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
