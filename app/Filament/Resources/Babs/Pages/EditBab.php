<?php

namespace App\Filament\Resources\Babs\Pages;

use App\Filament\Resources\Babs\BabResource;
use App\Filament\Resources\Kitabs\KitabResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Actions;
use Filament\Support\Icons\Heroicon;

class EditBab extends EditRecord
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
            KitabResource::getUrl('edit', ['record' => $kitab]) => $kitabTitle,
            BabResource::getUrl('edit', ['record' => $bab]) => $babTitle,
            'edit'
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Back')
                ->label('Kembali')
                ->color('primary')
                ->icon(Heroicon::ArrowLeft)
                ->button()
                ->url(fn() => KitabResource::getUrl('edit', ['record' =>  $this->record->kitab])),
            DeleteAction::make()
                ->icon(Heroicon::Trash),
            ForceDeleteAction::make()
                ->icon(Heroicon::Trash),
            RestoreAction::make()
                ->icon(Heroicon::ArrowPath),
        ];
    }
}
