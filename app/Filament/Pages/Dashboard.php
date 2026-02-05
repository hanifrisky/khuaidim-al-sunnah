<?php

namespace App\Filament\Pages;

use App\Models\Kitab;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends \Filament\Pages\Dashboard
{

    protected string $view = 'filament.resources.beranda';

    public function getTitle(): string | Htmlable
    {
        return "";
    }
    public function GetKitabs()
    {
        return Kitab::all();
    }
}
