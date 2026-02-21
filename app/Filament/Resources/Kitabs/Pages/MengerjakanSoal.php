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


class MengerjakanSoal extends Page
{
    use InteractsWithRecord;

    protected static string $resource = KitabResource::class;

    protected string $view = 'filament.resources.kitabs.pages.mengerjakan-soal';

    protected static ?string $title = '';

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
        $user = auth()->user()->siswa;

        if (!$user) {
            return [];
        }
        $kitab_id = $this->record->id;

        $haditsIds = SetoranHafalan::where('status', 'accepted')
            ->where('siswa_id', $user->id)
            ->pluck('hadit_id')
            ->toArray();


        // 2. Ambil 20 soal random berdasarkan hadits_id
        $soal = Soal::where('tipe', 'pemahaman')
            ->whereIn('hadits_id', $haditsIds)
            ->inRandomOrder()
            ->limit(20)
            ->with('jawaban')
            ->get();


        // 3. Jika kurang dari 20, tambahkan dari kitab yang sama
        if ($soal->count() < 20) {

            $kurang = 20 - $soal->count();

            $tambahan = Soal::where('tipe', 'pemahaman')
                ->where('kitab_id', $kitab_id) // <- nanti Anda supply
                ->whereNotIn('id', $soal->pluck('id')) // hindari duplikat
                ->inRandomOrder()
                ->limit($kurang)
                ->with('jawaban')
                ->get();

            $soal = $soal->merge($tambahan);
        }

        return $soal;

        return $soal;
    }

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
                'tipe' => 'pemahaman'
            ],
            [
                'kelas_id' => $siswa->kelas_id,
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
