<?php

namespace App\Filament\Resources\Kitabs\Pages;

use App\Filament\Resources\Kitabs\KitabResource;
use App\Helper\Authorization\AksesMenu;
use Filament\Resources\Pages\CreateRecord;

class CreateKitab extends CreateRecord
{
    use AksesMenu;
    protected static string $resource = KitabResource::class;
    protected static function menuRole(): array
    {
        return ['admin', 'guru'];
    }
    protected function getRedirectUrl(): string
    {
        return KitabResource::getUrl('edit');
    }
}
