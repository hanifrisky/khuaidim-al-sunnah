<?php

namespace App\Filament\Resources\Soals\Pages;

use App\Filament\Resources\Soals\SoalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListSoals extends ListRecords
{
    protected static string $resource = SoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            // 'semua' => Tab::make(),
            'الاستيعاب' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('tipe', 'pemahaman')),
            'إكمال الحديث' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('tipe', 'melanjutkan')),
        ];
    }
}
