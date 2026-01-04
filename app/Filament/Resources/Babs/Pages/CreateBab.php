<?php

namespace App\Filament\Resources\Babs\Pages;

use App\Filament\Resources\Babs\BabResource;
use App\Filament\Resources\Kitabs\KitabResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;

class CreateBab extends CreateRecord
{
    protected static string $resource = BabResource::class;
}
