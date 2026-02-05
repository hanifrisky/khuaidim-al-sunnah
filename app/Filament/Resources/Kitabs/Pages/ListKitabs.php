<?php

namespace App\Filament\Resources\Kitabs\Pages;

use App\Filament\Resources\Kitabs\KitabResource;
use App\Helper\Authorization\AksesMenu;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListKitabs extends ListRecords
{
    use AksesMenu;
    protected static string $resource = KitabResource::class;

    public function getBreadcrumbs(): array
    {
        return [];
    }
    public function getTitle(): string|Htmlable
    {
        return '';
    }
    protected static function menuRole(): array
    {
        return ['admin', 'guru', 'siswa'];
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn(): bool => !$this->isRole('siswa')),
        ];
    }
}
