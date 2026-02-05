<?php

namespace App\Filament\Resources\Babs\Pages;

use App\Filament\Pages\Dashboard;
use App\Filament\Resources\Babs\BabResource;
use App\Filament\Resources\Kitabs\KitabResource;
use App\Models\Bab;
use App\Models\Hadits;
use App\Models\Soal;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\On;


class ListHaditsKitab extends Page
{
    use InteractsWithRecord;

    protected static string $resource = BabResource::class;

    protected string $view = 'filament.resources.babs.pages.list-hadist';

    public function getBreadcrumbs(): array
    {
        $bab = $this->record;
        $kitab = $bab->kitab;
        $babTitle = $bab->name;
        $kitabTitle = $kitab->name;

        return [
            route('filament.admin.pages.dashboard') => 'Kitab',
            KitabResource::getUrl('babs', ['record' => $kitab]) => $kitabTitle,
            $babTitle,
        ];
    }
    public function getTitle(): string|Htmlable
    {
        return '';
    }
    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function GetBabs()
    {
        return $this->record;
    }

    public function GetHadits()
    {
        return Hadits::where('bab_id', $this->record->id)->get();
    }
}
