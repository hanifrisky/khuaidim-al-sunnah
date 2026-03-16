<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kitab;

class KitabSeeder extends Seeder
{
    public function run(): void
    {
        $kitabs = [
            [
                'name' => 'صحيح البخاري',
                'author' => 'Sahih Al-bukhari',
                'description' => '-',
                'media' => 'kitabs/cover/1.jpg',
            ],
            [
                'name' => 'صحيح مسلم',
                'author' => 'Sahih Muslim',
                'description' => '-',
                'media' => 'kitabs/cover/2.jpg',
            ],
            [
                'name' => 'سنن ابي داود',
                'author' => 'Sunan Abu Dawud',
                'description' => '-',
                'media' => 'kitabs/cover/3.jpg',
            ],
            [
                'name' => 'سنن الترمذي',
                'author' => 'Jami at-Tirmidzi',
                'description' => '-',
                'media' => 'kitabs/cover/4.jpg',
            ],
            [
                'name' => 'سنن النسائي',
                'author' => 'Sunan an-Nasa\'i',
                'description' => '-',
                'media' => 'kitabs/cover/5.jpg',
            ],
            [
                'name' => 'سنن ابن ماجه',
                'author' => 'Sunan Ibnu Majah',
                'description' => '-',
                'media' => 'kitabs/cover/6.jpg',
            ],
        ];
        foreach ($kitabs as $kitab) {
            Kitab::create($kitab);
        }
    }
}
