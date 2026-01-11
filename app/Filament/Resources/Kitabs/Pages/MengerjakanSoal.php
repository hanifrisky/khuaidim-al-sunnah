<?php

namespace App\Filament\Resources\Kitabs\Pages;

use App\Filament\Resources\Kitabs\KitabResource;
use App\Models\Soal;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class MengerjakanSoal extends Page
{
    use InteractsWithRecord;

    protected static string $resource = KitabResource::class;

    protected string $view = 'filament.resources.kitabs.pages.mengerjakan-soal';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function GetSoal()
    {
        return Soal::where('kitab_id', $this->record->id)->get();
    }
}
