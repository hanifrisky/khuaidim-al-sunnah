<?php

namespace Database\Seeders;

use App\Models\Bab;
use Illuminate\Database\Seeder;
use App\Models\Hadits;
use Maatwebsite\Excel\Facades\Excel;

class HaditsSeeder extends Seeder
{
    public function run(): void
    {
        $imports = [
            [
                'file' => 'hadits/1-bukhari.xlsx',
                'kitab_id' => 1,
            ],
            [
                'file' => 'hadits/2-muslim.xlsx',
                'kitab_id' => 2,
            ],
            [
                'file' => 'hadits/3-abu-dawud.xlsx',
                'kitab_id' => 3,
            ],
            [
                'file' => 'hadits/4-tirmidzi.xlsx',
                'kitab_id' => 4,
            ],
            [
                'file' => 'hadits/5-nasa-i.xlsx',
                'kitab_id' => 5,
            ],
            [
                'file' => 'hadits/6-ibnu-majah.xlsx',
                'kitab_id' => 6,
            ],
        ];

        foreach ($imports as $import) {
            $this->importFile(
                storage_path('app/' . $import['file']),
                $import['kitab_id']
            );
        }
    }

    private function importFile($filePath, $kitabId)
    {
        if (!file_exists($filePath)) {
            $this->command->error("File tidak ditemukan: {$filePath}");
            return;
        }

        $rows = Excel::toArray([], $filePath)[0];

        $rows = array_values(array_filter($rows, function ($row) {
            return isset($row[0]) && trim($row[0]) !== '';
        }));

        $total = count($rows);

        $countImport = 0;
        $babNumber = 1;
        $haditsInBab = 0;
        $currentBab = null;

        for ($i = 0; $i < $total; $i += 4) {
            if (!isset($rows[$i + 3])) {
                break;
            }

            // buat bab baru setiap 5 hadits
            if ($currentBab === null || $haditsInBab >= 5) {

                $currentBab = Bab::create([
                    'kitab_id' => $kitabId,
                    'name' => "bab {$babNumber} kitab {$kitabId}",
                    'description' => 'Description Bab',
                    'media' => null,
                ]);

                $babNumber++;
                $haditsInBab = 0;
            }

            $name = $rows[$i][0] ?? '';
            $contentRaw = $rows[$i + 1][0] ?? '';
            $translate1 = $rows[$i + 2][0] ?? '';
            $translate2 = $rows[$i + 3][0] ?? '';

            $content = '<p style="text-align: end;">' . $contentRaw . '</p>';

            $translate =
                '<p><strong>' . $translate1 . '</strong></p>' .
                '<p>' . $translate2 . '</p>';

            Hadits::create([
                'name' => $name,
                'content' => $content,
                'translate' => $translate,
                'bab_id' => $currentBab->id,
                'kitab_id' => $kitabId,
            ]);

            $haditsInBab++;
            $countImport++;
        }

        $this->command->info(
            "Import selesai ({$countImport}) dari file: " . basename($filePath)
        );
    }
}
