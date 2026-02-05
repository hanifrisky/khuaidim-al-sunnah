<?php

namespace App\Filament\Pages;

use App\Models\Kitab;
use App\Models\Quote;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends \Filament\Pages\Dashboard
{

    protected string $view = 'filament.resources.beranda';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Home;

    public function getTitle(): string | Htmlable
    {
        return "";
    }
    public function GetKitabs()
    {
        return Kitab::all();
    }
    public function getQuote()
    {
        $quote = Quote::inRandomOrder()->first();
        if (!$quote)
            return "Random Inspiring";
        return $quote->konten;
    }
}
