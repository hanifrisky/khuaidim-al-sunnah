<?php

namespace App\Filament\Resources\Kitabs\Pages;

use App\Filament\Resources\Kitabs\KitabResource;
use App\Helper\Authorization\AksesMenu;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewKitab extends ViewRecord
{
    public function getBreadcrumbs(): array
    {
        $kitab = $this->record;
        $kitabTitle = $kitab->name;

        return [
            KitabResource::getUrl() => 'Kitab',
            KitabResource::getUrl('view', ['record' => $kitab]) => $kitabTitle
        ];
    }

    use AksesMenu;
    protected static function menuRole(): array
    {
        return ['admin', 'guru', 'siswa'];
    }
    protected static string $resource = KitabResource::class;
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->visible(fn() => self::isRole('admin')),
            Action::make('Soal')

        ];
    }
}
