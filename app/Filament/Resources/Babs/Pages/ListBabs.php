<?php

namespace App\Filament\Resources\Babs\Pages;

use App\Filament\Resources\Babs\BabResource;
use App\Helper\Authorization\AksesMenu;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBabs extends ListRecords
{
    protected static string $resource = BabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    use AksesMenu;
    protected static function menuRole(): array
    {
        return ['admin'];
    }
}
