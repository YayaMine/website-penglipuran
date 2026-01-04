<?php

namespace App\Filament\Resources\TicketVersionResource\Pages;

use App\Filament\Resources\TicketVersionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicketVersion extends EditRecord
{
    protected static string $resource = TicketVersionResource::class;
    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
