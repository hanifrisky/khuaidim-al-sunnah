<?php

namespace App\Filament\Resources\TugasHafalans\Pages;

use App\Filament\Resources\TugasHafalans\TugasHafalanResource;
use App\Models\Kelas;
use App\Models\Pesan;
use App\Models\Siswa;
use App\Models\TugasHafalan;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateTugasHafalan extends CreateRecord
{
    protected static string $resource = TugasHafalanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        //set tipe mengirim ke individu atau kelas
        $title = "Tugas Hafalan ";
        $kelas_id = $data['kelas_id'];
        // if ($data['assign'] == 'individu') {
        //     $data['kelas_id'] = null;

        //     //ambil siswa kemudian ambil kelasnya
        //     $siswa = Siswa::find($data['siswa_id']);
        //     $kelas_id = $siswa->kelas_id;
        // } else {
        //     $data['siswa_id'] = null;
        //     $kelas_id = $data['kelas_id'];
        // }

        //set tipe hafalan hadits atau bab
        // if ($data['type'] == 'hadits') {
        //     $data['bab_id'] = null;
        //     $hadits = \App\Models\Hadits::find($data['hadits_id']);
        //     $title .= $hadits->title;
        //     $title .= " " . $hadits->kitab->name;
        // } else {
        //     $data['hadits_id'] = null;
        //     $bab = \App\Models\Bab::find($data['bab_id']);
        //     $title .= $bab->name;
        //     $title .= " " . $bab->kitab->name;
        // }

        $data['hadits_id'] = null;
        $bab = \App\Models\Bab::find($data['bab_id']);
        $title .= $bab->name;
        $title .= " " . $bab->kitab->name;

        //set title
        $data['title'] = $title;

        //set guru_id
        $kelas = Kelas::find($kelas_id);
        $data['guru_id'] = $kelas->guru_id;

        return $data;
    }
    public function create(bool $another = false): void
    {
        $data = $this->form->getState();
        $bab_id = $data['bab_id'];
        $kelas_id = $data['kelas_id'];
        if (TugasHafalan::where('bab_id', $bab_id)->where('kelas_id', $kelas_id)->exists()) {
            Notification::make()
                ->title('Gagal!')
                ->body('Sudah membuat Tugas untuk bab ini')
                ->danger()
                ->send();
            return;
        }

        parent::create($another);
    }
    public function afterCreate()
    {
        $record = $this->record;
        if ($record->status == 'draft') {
            return;
        }
        $bab = $record->bab;

        $hadits = $record->hadits;
        //$kelas = Kelas::find($record->kelas_id);
        $siswas = Siswa::where('kelas_id', $record->kelas_id)->get();
        foreach ($siswas as $siswa) {
            Pesan::create([
                'siswa_id' => $siswa->id,
                'pesan' => $record->title,
                'action' => route(
                    'filament.admin.pages.video-bab.upload',
                    ['id' => $bab->id]
                ),
                'status' => 'unread'
            ]);
        }
    }
}
