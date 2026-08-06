<?php

namespace App\Filament\Resources\Soals\Pages;

use App\Filament\Resources\Soals\SoalResource;
use App\Models\Bab;
use App\Models\Hadits;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSoal extends EditRecord
{
    protected static string $resource = SoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $hadits_id = $data['hadits_id'] ?? null;
        if ($hadits_id) {
            $hadits = Hadits::find($hadits_id);
            if ($hadits) {
                $data['bab_id'] = $hadits->bab_id;
                $data['kitab_id'] = $hadits->kitab_id;
            }
        }
        return $data;
    }
}
