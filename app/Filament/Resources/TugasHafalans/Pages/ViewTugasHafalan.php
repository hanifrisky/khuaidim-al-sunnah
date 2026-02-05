<?php

namespace App\Filament\Resources\TugasHafalans\Pages;

use App\Filament\Resources\TugasHafalans\TugasHafalanResource;
use App\Helper\Authorization\AksesMenu;
use App\Models\Kelas;
use App\Models\Siswa;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewTugasHafalan extends ViewRecord
{
    protected static string $resource = TugasHafalanResource::class;
    public function form(Schema $schema): Schema
    {
        return $schema;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    public static function canView($record): bool
    {
        return true;
    }
}
