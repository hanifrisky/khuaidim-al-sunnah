<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\PilihanJawaban;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class SoalPemahamanSeeder extends Seeder
{
    public function run(): void
    {
        $imports = [
            [
                'file' => 'soal/1-bukhari.xlsx',
                'kitab_id' => 1,
            ],
            [
                'file' => 'soal/2-muslim.xlsx',
                'kitab_id' => 2,
            ],
            [
                'file' => 'soal/3-abu-dawud.xlsx',
                'kitab_id' => 3,
            ],
            [
                'file' => 'soal/4-tirmidzi.xlsx',
                'kitab_id' => 4,
            ],
            [
                'file' => 'soal/5-nasa-i.xlsx',
                'kitab_id' => 5,
            ],
            [
                'file' => 'soal/6-ibnu-majah.xlsx',
                'kitab_id' => 6,
            ],
        ];

        foreach ($imports as $import) {

            $rows = Excel::toArray([], storage_path('app/' . $import['file']))[0] ?? [];

            if (empty($rows)) continue;

            DB::transaction(function () use ($rows, $import) {

                // Ambil kunci jawaban (baris 242 = index 241)
                $kunciRow = $rows[241][0] ?? null;
                $kunci = $this->parseKunciJawaban($kunciRow);

                for ($i = 0; $i < 40; $i++) {

                    $baseIndex = $i * 6;

                    $soalRaw = $rows[$baseIndex][0] ?? null;
                    if (!$soalRaw) continue;

                    $soalText = $this->cleanSoal($soalRaw);

                    // Ambil 4 pilihan
                    $pilihan = [];
                    for ($j = 1; $j <= 4; $j++) {
                        $pilihan[] = $this->cleanPilihan(
                            $rows[$baseIndex + $j][0] ?? ''
                        );
                    }

                    // Ambil petunjuk
                    $petunjukRaw = $rows[$baseIndex + 5][0] ?? null;
                    $petunjuk = $this->cleanPetunjuk($petunjukRaw);

                    // Simpan soal
                    $soal = Soal::create([
                        'kitab_id'  => $import['kitab_id'],
                        'hadits_id' => null,
                        'tipe'      => 'pemahaman',
                        'soal'      => $soalText,
                        'petunjuk'  => $petunjuk,
                        'media'     => null,
                    ]);

                    // Simpan pilihan jawaban
                    foreach ($pilihan as $index => $jawabanText) {

                        $huruf = chr(65 + $index); // A, B, C, D

                        PilihanJawaban::create([
                            'soal_id' => $soal->id,
                            'jawaban' => $jawabanText,
                            'benar'   => isset($kunci[$i + 1]) && $kunci[$i + 1] === $huruf,
                        ]);
                    }
                }
            });
        }
    }

    protected function cleanSoal($text)
    {
        return trim(preg_replace('/^\d+\.\s*/', '', $text));
    }

    protected function cleanPilihan($text)
    {
        return trim(preg_replace('/^[A-D]\.\s*/', '', $text));
    }

    protected function cleanPetunjuk($text)
    {
        return trim(preg_replace('/^Petunjuk:\s*/i', '', $text));
    }

    protected function parseKunciJawaban($text)
    {
        $hasil = [];

        if (!$text) return $hasil;

        preg_match_all('/(\d+)\.\s*([A-D])/', $text, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $hasil[(int)$match[1]] = strtoupper($match[2]);
        }

        return $hasil;
    }
}
