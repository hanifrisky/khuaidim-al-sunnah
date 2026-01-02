<?php

namespace App\Filament\Resources\SetoranHafalans\Pages;

use App\Filament\Resources\SetoranHafalans\SetoranHafalanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSetoranHafalan extends EditRecord
{
    protected static string $resource = SetoranHafalanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
