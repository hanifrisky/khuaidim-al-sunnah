<?php

namespace App\Filament\Resources\NilaiSoals\Pages;

use App\Filament\Resources\NilaiSoals\NilaiSoalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListNilaiSoals extends ListRecords
{
    protected static string $resource = NilaiSoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            // 'semua' => Tab::make(),
            'إكمال الحديث' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('tipe', 'pemahaman')),
            'الاستيعاب' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('tipe', 'melanjutkan')),
        ];
    }
}
