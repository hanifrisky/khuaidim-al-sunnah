<?php

namespace App\Filament\Resources\Babs\Pages;

use App\Filament\Resources\Babs\BabResource;
use App\Filament\Resources\Kitabs\KitabResource;
use App\Helper\Authorization\AksesMenu;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBab extends ViewRecord
{
    protected static string $resource = BabResource::class;
    public function getBreadcrumbs(): array
    {
        $bab = $this->record;
        $kitab = $bab->kitab;
        $babTitle = $bab->name;
        $kitabTitle = $kitab->name;

        return [
            KitabResource::getUrl() => 'Kitab',
            KitabResource::getUrl('view', ['record' => $kitab]) => $kitabTitle,
            BabResource::getUrl('view', ['record' => $bab]) => $babTitle,
        ];
    }
    use AksesMenu;
    protected static function menuRole(): array
    {
        return ['admin', 'guru', 'siswa'];
    }
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->visible(fn() => self::isRole('admin')),
        ];
    }
}
