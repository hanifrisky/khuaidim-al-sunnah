<?php

namespace App\Filament\Resources\Kitabs\Pages;

use App\Filament\Resources\Kitabs\KitabResource;
use App\Models\NilaiSoal;
use App\Models\SetoranHafalan;
use App\Models\Soal;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Livewire\Attributes\On;


class MengerjakanSoalMelanjutkan extends Page
{
    use InteractsWithRecord;

    protected static string $resource = KitabResource::class;

    protected string $view = 'filament.resources.kitabs.pages.mengerjakan-soal';

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function GetSoal()
    {
        // 1. Ambil hadits_id dari setoran yang approved
        $user = Auth()->user()->siswa;
        if (!$user) {
            return [];
        }

        $haditsIds = SetoranHafalan::where('status', 'accepted')
            ->where('siswa_id', $user->id)
            ->pluck('hadit_id') // hasil: Collection
            ->toArray();

        // 2. Ambil soal berdasarkan hadits_id tersebut
        $soal = Soal::where('tipe', 'melanjutkan')
            ->whereIn('hadits_id', $haditsIds)
            ->with('jawaban')
            ->limit(20)
            ->get();

        return $soal;
    }
    protected static ?string $title = '';
    #[On('selesai-kuis')]
    public function selesai(int $nilai)
    {
        $siswa = Auth()->user()->siswa;
        if (!$siswa) {
            Notification::make()
                ->title('Gagal!')
                ->body('User siswa tidak ditemukan')
                ->danger()
                ->send();
            return;
        }
        NilaiSoal::updateOrCreate(
            [
                'siswa_id' => $siswa->id,
                'kitab_id' => $this->record->id,
                'tipe' => 'melanjutkan'
            ],
            [
                'nilai' => $nilai,
            ]
        );
        Notification::make()
            ->title('Berhasil!')
            ->body('Nilai sudah masuk!')
            ->success()
            ->send();

        return redirect()->route('filament.admin.resources.kitabs.babs', $this->record->id);
    }
}
