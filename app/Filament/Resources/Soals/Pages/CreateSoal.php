<?php

namespace App\Filament\Resources\Soals\Pages;

use App\Filament\Resources\Soals\SoalResource;
use App\Models\Hadits;
use Filament\Resources\Pages\CreateRecord;

class CreateSoal extends CreateRecord
{
    protected static string $resource = SoalResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $hadits_id = $data['hadits_id'];
        $hadits = Hadits::find($hadits_id);
        $bab_id = $hadits->bab_id;
        $kitab_id = $hadits->kitab_id;

        $data['bab_id'] = $bab_id;
        $data['kitab_id'] = $kitab_id;
        return $data;
    }
}
