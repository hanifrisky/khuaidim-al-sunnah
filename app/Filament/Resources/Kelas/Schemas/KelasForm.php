<?php

namespace App\Filament\Resources\Kelas\Schemas;

use App\Helper\Authorization\AksesMenu;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KelasForm
{
    use AksesMenu;
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('الاسم')
                    ->required(),
                Hidden::make('guru_id')
                    ->default(self::guruId())
                    ->visible(fn(): bool => self::isRole('guru')),
                Select::make('guru_id')
                    ->options(function () {
                        return \App\Models\Guru::all()->pluck('user.name', 'id');
                    })
                    ->hidden(fn(): bool => self::isRole('guru'))
                    ->searchable()
                    ->preload()
                    ->label('الأستاذ المشرف')
                    ->required(),
            ])
            ->columns(3);
    }
}
