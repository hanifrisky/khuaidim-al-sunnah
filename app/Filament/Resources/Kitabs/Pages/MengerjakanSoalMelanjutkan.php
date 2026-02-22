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

    protected string $view = 'filament.resources.kitabs.pages.mengerjakan-soal-melanjutkan';

    protected $jumlahSoal = 5;

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
    public function multiplierNilai()
    {
        return 5;
    }
    public function getKitabName()
    {
        return $this->record->name;
    }

    public function GetSoal()
    {
        // 1. Ambil hadits_id dari setoran yang approved
        $user = Auth()->user()->siswa;
        if (!$user) {
            return [];
        }

        $kitab_id = $this->record->id;

        $haditsIds = SetoranHafalan::where('status', 'accepted')
            ->where('siswa_id', $user->id)
            ->pluck('hadit_id')
            ->toArray();


        // 2. Ambil $this->jumlahSoal soal random berdasarkan hadits_id
        $soal = Soal::where('tipe', 'melanjutkan')
            ->whereIn('hadits_id', $haditsIds)
            ->inRandomOrder()
            ->limit($this->jumlahSoal)
            ->with('jawaban')
            ->get();


        // 3. Jika kurang dari 20, tambahkan dari kitab yang sama
        if ($soal->count() < $this->jumlahSoal) {

            $kurang = $this->jumlahSoal - $soal->count();

            $tambahan = Soal::where('tipe', 'melanjutkan')
                ->where('kitab_id', $kitab_id) // <- nanti Anda supply
                ->whereNotIn('id', $soal->pluck('id')) // hindari duplikat
                ->inRandomOrder()
                ->limit($kurang)
                ->with('jawaban')
                ->get();

            $soal = $soal->merge($tambahan);
        }

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
