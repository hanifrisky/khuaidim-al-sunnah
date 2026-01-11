<?php

namespace App\Filament\Resources\Kitabs\Pages;

use App\Filament\Resources\Kitabs\KitabResource;
use App\Helper\Authorization\AksesMenu;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKitabs extends ListRecords
{
    protected static string $resource = KitabResource::class;

    public function getBreadcrumbs(): array
    {
        return [];
    }
    use AksesMenu;
    protected static function menuRole(): array
    {
        return ['admin', 'guru', 'siswa'];
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
