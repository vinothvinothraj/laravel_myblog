<?php

namespace App\Filament\Resources\TvAdvertsResource\Pages;

use App\Filament\Resources\TvAdvertsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTvAdverts extends EditRecord
{
    protected static string $resource = TvAdvertsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
