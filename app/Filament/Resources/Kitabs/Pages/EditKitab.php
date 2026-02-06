<?php

namespace App\Filament\Resources\Kitabs\Pages;

use App\Filament\Resources\Kitabs\KitabResource;
use App\Helper\Authorization\AksesMenu;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditKitab extends EditRecord
{
    use AksesMenu;
    protected static string $resource = KitabResource::class;

    protected static function menuRole(): array
    {
        return ['admin'];
    }
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
