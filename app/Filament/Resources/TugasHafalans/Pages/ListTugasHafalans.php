<?php

namespace App\Filament\Resources\TugasHafalans\Pages;

use App\Filament\Resources\TugasHafalans\TugasHafalanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTugasHafalans extends ListRecords
{
    protected static string $resource = TugasHafalanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
