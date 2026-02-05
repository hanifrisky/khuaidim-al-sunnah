<?php

namespace App\Filament\Resources\TugasHafalans\Pages;

use App\Filament\Resources\TugasHafalans\TugasHafalanResource;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TugasHafalan;
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
    public function afterCreate()
    {
        $record = $this->record;
        if ($record->status == 'draft') {
            return;
        }
        $bab = $record->bab;

        $hadits = $record->hadits;
        $kelas = Kelas::find($record->kelas_id);
        $siswas = Siswa::where('kelas_id', $kelas->id)->get();

        dd($kelas, $siswas);

        foreach ($siswas as $siswa) {
            foreach ($hadits as $hadit) {
                TugasHafalan::create([
                    'tugas_hafalan_id' => $record->id,
                    'siswa_id' => $siswa->id,
                    'hadit_id' => $hadit->id,
                    'status' => 'draft'
                ]);
            }
        }
    }
}
