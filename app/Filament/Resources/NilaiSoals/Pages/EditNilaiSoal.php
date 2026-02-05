<?php

namespace App\Filament\Resources\NilaiSoals\Pages;

use App\Filament\Resources\NilaiSoals\NilaiSoalResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNilaiSoal extends EditRecord
{
    protected static string $resource = NilaiSoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
