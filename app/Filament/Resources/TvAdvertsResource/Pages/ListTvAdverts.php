<?php

namespace App\Filament\Resources\TvAdvertsResource\Pages;

use App\Filament\Resources\TvAdvertsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Infolists\Components\TextEntry;
class ListTvAdverts extends ListRecords
{
    protected static string $resource = TvAdvertsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
