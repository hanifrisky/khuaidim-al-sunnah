<?php

namespace App\Filament\Resources\SetoranHafalans\Pages;

use App\Filament\Resources\SetoranHafalans\SetoranHafalanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSetoranHafalans extends ListRecords
{
    protected static string $resource = SetoranHafalanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
