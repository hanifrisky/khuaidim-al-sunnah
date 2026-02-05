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

        return Hadits::where('name', 'like', '%' . $this->q . '%')
            ->orWhere('content', 'like', '%' . $this->q . '%')
            ->orWhere('keterangan', 'like', '%' . $this->q . '%')
            ->orWhere('source', 'like', '%' . $this->q . '%')
            ->orWhere('translate', 'like', '%' . $this->q . '%')
            ->orderBy('id')
            ->get();
    }
}
