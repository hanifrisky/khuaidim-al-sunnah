<?php

namespace App\Filament\Resources\Kitabs\Pages;

use App\Filament\Resources\Kitabs\KitabResource;
use App\Models\Bab;
use App\Models\Soal;
use App\Models\TugasHafalan;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\On;


class ListBabKitab extends Page
{
    use InteractsWithRecord;

    protected static string $resource = KitabResource::class;

    protected string $view = 'filament.resources.kitabs.pages.list-babs';

    public int $kelas_id;

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $user = auth()->user()->siswa;

        // contoh: kelas aktif user
        $this->kelas_id = $user->kelas_id;
    }
    public function GetKitab()
    {
        return $this->record;
    }

    public function getTitle(): string|Htmlable
    {
        return '';
    }

    public function Getbabs()
    {
        return Bab::where('kitab_id', $this->record->id)->get();
    }
    public bool $showVideoModal = false;
    public $videoBabs = [];

    public function openVideoModal()
    {
        $this->videoBabs = Bab::where('kitab_id', $this->record->id)->get();
        $this->showVideoModal = true;
    }

    public function closeVideoModal()
    {
        $this->showVideoModal = false;
    }
    public function selectBab(int $babId)
    {
        $tugas = TugasHafalan::where('kelas_id', $this->kelas_id)
            ->where('bab_id', $babId)
            ->where('status', 'publish')
            ->first();

        if ($tugas) {
            // MISAL: redirect ke detail tugas
            return redirect()->route(
                'filament.admin.pages.video-bab.upload',
                ['id' => $babId]
            );
        }
        $this->closeVideoModal();

        Notification::make()
            ->title('Tugas Hafalan Belum Tersedia')
            ->body('Belum ada tugas hafalan untuk bab ini.')
            ->warning()
            ->send();
    }
}
