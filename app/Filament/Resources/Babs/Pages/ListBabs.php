<?php

namespace App\Filament\Resources\Babs\Pages;

use App\Filament\Resources\Babs\BabResource;
use App\Helper\Authorization\AksesMenu;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBabs extends ListRecords
{
    use AksesMenu;
    protected static string $resource = BabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn(): bool => !$this->isRole('siswa')),
        ];
    }

    protected static function menuRole(): array
    {
        return ['admin'];
    }
}
