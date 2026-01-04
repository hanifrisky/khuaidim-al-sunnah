<?php

namespace App\Filament\Resources\Kelas\Pages;

use App\Filament\Resources\Kelas\KelasResource;
use App\Helper\RedirectToList;
use Filament\Resources\Pages\CreateRecord;

class CreateKelas extends CreateRecord
{
    use RedirectToList;
    protected static string $resource = KelasResource::class;
}
