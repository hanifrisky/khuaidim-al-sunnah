<?php

namespace App\Filament\Resources\Hadits\Pages;

use App\Filament\Resources\Hadits\HaditsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditHadits extends EditRecord
{
    protected static string $resource = HaditsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
