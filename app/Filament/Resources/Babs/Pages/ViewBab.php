<?php

namespace App\Filament\Resources\Babs\Pages;

use App\Filament\Resources\Babs\BabResource;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBabs extends ViewRecord
{
    protected static string $resource = BabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
