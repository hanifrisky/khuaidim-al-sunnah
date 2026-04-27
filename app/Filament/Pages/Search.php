<?php

namespace App\Filament\Pages;

use App\Models\Hadits;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class Search extends Page
{
    protected string $view = 'filament.resources.search';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'ابحث';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::MagnifyingGlass;
    /** query pencarian */
    public string $q = '';

    protected $queryString = [
        'q' => ['except' => ''],
    ];
    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->user()->siswa) {
            return true;
        }
        return false;
    }

    public function mount()
    {
        // ambil q dari URL (?q=...)
        $this->q = request()->query('q', '');
    }

    public function getTitle(): string|Htmlable
    {
        return '';
    }

    public function getResults()
    {
        if (blank($this->q)) {
            return collect(); // kosongkan kalau tidak ada q
        }

        $search = strtolower($this->q);

        // angka arab → latin
        $search = $this->arabicToLatinNumber($search);

        // normalisasi arab
        $searchNormalized = $this->normalizeArabic($search);

        $terms = explode(' ', $searchNormalized);

        $booleanQuery = collect($terms)
            ->filter()
            ->map(fn($term) => '+' . $term . '*')
            ->implode(' ');

        $results = Hadits::selectRaw("
        *,
        MATCH(content_normalized, name_normalized, translate, source)
        AGAINST(? IN BOOLEAN MODE) as score
    ", [$booleanQuery])
            ->whereRaw("
        MATCH(content_normalized, name_normalized, translate, source)
        AGAINST(? IN BOOLEAN MODE)
    ", [$booleanQuery])
            ->orderByDesc('score')
            ->get();

        return $results;
    }
    private function arabicToLatinNumber($text)
    {
        $arabic  = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $latin   = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($arabic, $latin, $text);
    }
    private function normalizeArabic($text)
    {
        $text = str_replace(
            ['bukhari', 'muslim', 'abu dawud', 'tirmidzi', 'nasai', 'ibnu majah'],
            ['صحيح البخاري', 'صحيح مسلم', 'سنن ابي داود', 'سنن الترمذي', 'سنن النسائي', 'سنن ابن ماجه'],
            $text
        );

        // Hapus harakat (tashkeel)
        $text = preg_replace('/[\x{064B}-\x{065F}\x{0670}]/u', '', $text);

        // Normalisasi huruf
        $search  = ['أ', 'إ', 'آ', 'ى', 'ة', 'ؤ', 'ئ'];
        $replace = ['ا', 'ا', 'ا', 'ي', 'ه', 'و', 'ي'];

        $text = str_replace($search, $replace, $text);

        // Hapus karakter non huruf (opsional tapi bagus untuk search)
        $text = preg_replace('/[^\p{Arabic}\s]/u', ' ', $text);

        // Rapikan spasi
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }
}
