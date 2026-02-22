<?php

namespace App\Filament\Resources\NilaiSoals\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NilaiSoalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('siswa_id')
                    ->relationship('siswa', 'name')
                    ->searchable()
                    ->preload()
                    ->label('الطلاب')
                    ->required(),
                TextInput::make('nilai')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('kitab_id')
                    ->numeric(),
            ]);
    }
}
