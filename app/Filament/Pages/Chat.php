<?php

namespace App\Filament\Pages;

use App\Models\Hadits;
use App\Models\Pesan;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class Chat extends Page
{
    protected string $view = 'filament.resources.chat';
    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChatBubbleLeft;
    /** query pencarian */

    public function mount() {}

    public function getTitle(): string|Htmlable
    {
        return '';
    }

    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->user()->siswa) {
            return true;
        }
        return false;
    }
    public function getResults()
    {
        $siswa = auth()->user()->siswa;
        if ($siswa == null) {
            return collect(); // kosongkan kalau tidak ada q
        }
        return Pesan::where('siswa_id', $siswa->id)
            ->orderBy('updated_at', 'desc')
            ->get();
    }
    public function aksiPesan(Pesan $pesan)
    {
        $pesan->status = 'read';
        $pesan->save();
        return redirect($pesan->action);
    }
}
