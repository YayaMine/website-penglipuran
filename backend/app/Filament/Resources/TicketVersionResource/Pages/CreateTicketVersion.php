<?php

namespace App\Filament\Resources\TicketVersionResource\Pages;

use App\Filament\Resources\TicketVersionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTicketVersion extends CreateRecord
{
    protected static string $resource = TicketVersionResource::class;
    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }
}
