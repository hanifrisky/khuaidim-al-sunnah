<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quote;

class QuoteSeeder extends Seeder
{
    public function run(): void
    {
        $quotes = [
            [
                'title' => 'Kesempatan Baru',
                'konten' => 'لا تؤجل أحلامك، فكل يوم فرصة جديدة.<br>"Jangan tunda mimpimu, setiap hari adalah kesempatan baru."',
            ],
            [
                'title' => 'Kesabaran',
                'konten' => 'الصبر مفتاح الفرج.<br>"Kesabaran adalah kunci jalan keluar."',
            ],
            [
                'title' => 'Kesungguhan',
                'konten' => 'من جدّ وجد.<br>"Siapa yang bersungguh-sungguh akan berhasil."',
            ],
            [
                'title' => 'Harapan',
                'konten' => 'الأمل نور لا ينطفئ.<br>"Harapan adalah cahaya yang tidak pernah padam."',
            ],
            [
                'title' => 'Masa Depan',
                'konten' => 'تعلم من الأمس، وعش اليوم، واصنع الغد.<br>"Belajarlah dari kemarin, jalani hari ini, dan ciptakan masa depan."',
            ],
            [
                'title' => 'Langkah Awal',
                'konten' => 'النجاح يبدأ بخطوة.<br>"Kesuksesan dimulai dari satu langkah."',
            ],
            [
                'title' => 'Kebaikan',
                'konten' => 'كن لطيفًا، فالكلمات الجميلة تبقى.<br>"Jadilah lembut, karena kata-kata indah akan selalu tinggal."',
            ],
            [
                'title' => 'Hati yang Baik',
                'konten' => 'القلب الطيب يرى الجمال في كل شيء.<br>"Hati yang baik melihat keindahan dalam segala hal."',
            ],
            [
                'title' => 'Kepercayaan kepada Allah',
                'konten' => 'الثقة بالله تصنع المستحيل.<br>"Percaya kepada Allah membuat yang mustahil menjadi mungkin."',
            ],
            [
                'title' => 'Senyuman',
                'konten' => 'ابتسم، فالحياة أجمل بالأمل.<br>"Tersenyumlah, hidup lebih indah dengan harapan."',
            ],
        ];

        foreach ($quotes as $quote) {
            Quote::create($quote);
        }
    }
}
