<?php

namespace App\Filament\Resources\TugasHafalans\Pages;

use App\Filament\Resources\TugasHafalans\TugasHafalanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTugasHafalan extends EditRecord
{
    protected static string $resource = TugasHafalanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
