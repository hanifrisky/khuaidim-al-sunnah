<?php

namespace App\Filament\Resources\Hadits\Pages;

use App\Filament\Resources\Hadits\HaditsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHadits extends ListRecords
{
    protected static string $resource = HaditsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
