<?php

namespace App\Filament\Resources\TicketVersionResource\Pages;

use App\Filament\Resources\TicketVersionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTicketVersions extends ListRecords
{
    protected static string $resource = TicketVersionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
