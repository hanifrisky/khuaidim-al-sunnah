<?php

namespace App\Filament\Resources\SetoranHafalans\Pages;

use App\Filament\Resources\SetoranHafalans\SetoranHafalanResource;
use App\Models\Bab;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Grouping\Group;

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
