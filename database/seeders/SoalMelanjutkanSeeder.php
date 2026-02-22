<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\PilihanJawaban;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class SoalMelanjutkanSeeder extends Seeder
{
    public function run(): void
    {
        $imports = [
            [
                'file' => 'melanjutkan/1-bukhari.xlsx',
                'kitab_id' => 1,
            ],
            [
                'file' => 'melanjutkan/2-muslim.xlsx',
                'kitab_id' => 2,
            ],
        ];

        foreach ($imports as $import) {

            $rows = Excel::toArray([], storage_path('app/' . $import['file']))[0] ?? [];
            if (empty($rows)) continue;

            DB::transaction(function () use ($rows, $import) {

                $kunci = $this->parseKunciJawaban(array_slice($rows, 161));

                for ($i = 0; $i < 40; $i++) {

                    $baseIndex = $i * 4;

                    $soalRaw = $rows[$baseIndex][0] ?? null;
                    if (!$soalRaw) continue;

                    $soalText = $this->cleanSoal($soalRaw);

                    $opsi = [];
                    for ($j = 1; $j <= 3; $j++) {
                        $opsi[] = $this->cleanOpsi(
                            $rows[$baseIndex + $j][0] ?? ''
                        );
                    }

                    $soal = Soal::create([
                        'kitab_id'  => $import['kitab_id'],
                        'hadits_id' => null,
                        'tipe'      => 'melanjutkan',
                        'soal'      => $soalText,
                        'petunjuk'  => null,
                        'media'     => null,
                    ]);

                    // mapping posisi default A,B,C
                    $mapping = [
                        'A' => 1,
                        'B' => 2,
                        'C' => 3,
                    ];

                    $urutan = $kunci[$i + 1] ?? null; // contoh: B-A-C
                    $urutanArray = $urutan ? explode('-', $urutan) : [];

                    foreach ($opsi as $index => $text) {

                        $huruf = chr(65 + $index); // A,B,C

                        // Tentukan sort berdasarkan posisi dalam kunci
                        $sort = 0;

                        if (!empty($urutanArray)) {
                            $position = array_search($huruf, $urutanArray);
                            if ($position !== false) {
                                $sort = $position + 1;
                            }
                        }

                        PilihanJawaban::create([
                            'soal_id' => $soal->id,
                            'jawaban' => $text,
                            'sort'    => $sort,
                            'benar'   => false,
                        ]);
                    }
                }
            });
        }
    }

    protected function cleanSoal($text)
    {
        $val = $text;
        $val = str_replace('...', '', $val);
        return trim(preg_replace('/^\d+\.\s*/u', '', $val));
    }

    protected function cleanOpsi($text)
    {
        // Hapus huruf arab + ) termasuk karakter RTL tersembunyi
        $val = trim($text);
        $val = str_replace('‌ب)', '', $val);
        $val = str_replace('‌أ)', '', $val);
        $val = str_replace('ج)', '', $val);

        return trim($val);
    }

    protected function parseKunciJawaban($rows)
    {
        $hasil = [];

        foreach ($rows as $row) {

            $text = $row[0] ?? null;
            if (!$text) continue;

            if (!preg_match('/^(\d+)\./u', $text, $numMatch)) {
                continue;
            }

            $nomor = (int) $numMatch[1];

            // Format normal
            if (preg_match('/\|\s*([A-C]\s*-\s*[A-C]\s*-\s*[A-C])/', $text, $match)) {
                $hasil[$nomor] = strtoupper(str_replace(' ', '', $match[1]));
                continue;
            }

            // Format hanya arab
            if (preg_match('/\((.*?)\)/u', $text, $match)) {

                $mapping = [
                    'أ' => 'A',
                    'ب' => 'B',
                    'ج' => 'C',
                ];

                $parts = preg_split('/\s*-\s*/u', $match[1]);

                $latin = [];

                foreach ($parts as $huruf) {
                    $huruf = trim($huruf);
                    if (isset($mapping[$huruf])) {
                        $latin[] = $mapping[$huruf];
                    }
                }

                if (count($latin) === 3) {
                    $hasil[$nomor] = implode('-', $latin);
                }
            }
        }

        return $hasil;
    }
}
